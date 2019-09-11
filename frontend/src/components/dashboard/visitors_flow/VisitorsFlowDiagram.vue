<template>
    <div id="visitors-flow-container">
        <div class="overflow" />
        <svg id="visitors-flow-diagram" />
        <div class="step">
            <button
                :disabled="addInteractionDisabled"
                class="step-button"
                @click="addInteraction"
            >
                <FontAwesomeIcon
                    :icon="['fas', 'arrow-right']"
                    class="step-arrow"
                    size="5x"
                />
            </button>
            <small class="text-muted">
                Add step
            </small>
        </div>
    </div>
</template>

<script>
    import * as d3 from "d3";
    import { sankey, sankeyLinkHorizontal, sankeyLeft } from "d3-sankey";

    export default {
        name: "VisitorsFlowDiagram",
        props: {
            visitorsFlowData: {
                type: Array,
                required: true
            },
            currentLevel: {
                type: Number,
                required: true
            }
        },
        watch: {
            visitorsFlowData: function () {
                this.addInteractionDisabled = this.lastLevel === this.currentLevel;
                this.lastLevel = this.currentLevel;
                this.parseVisitorsFlowData();
                this.drawDiagram();
            }
        },
        data () {
            return {
                titles: [
                    'Starting pages',
                    '1st Interaction',
                    '2nd Interaction',
                    '3rd Interaction'
                ],
                height: 600,
                tooltip: {},
                lastLevel: 0,
                nodes: [],
                links: [],
                exits: [],
                addInteractionDisabled: false
            };
        },
        computed: {
            width () {
                return Math.max(this.nodes.length / 5 * 400, 1200);
            }
        },
        mounted() {
            this.parseVisitorsFlowData();
            this.drawDiagram();
        },
        methods: {
            parseVisitorsFlowData () {
                let nodes = [];
                let links = [];
                let exits = [];

                let visitorsFlow = this.visitorsFlowData;

                for (let key in visitorsFlow) {
                    let visitorFlowItem = visitorsFlow[key];

                    let sourceId = this.findOrCreateSource(visitorFlowItem, nodes);
                    let targetId = this.findOrCreateTarget(visitorFlowItem, nodes);

                    this.findOrCreateLink(visitorFlowItem, links, sourceId, targetId);
                    this.findOrCreateExit(visitorFlowItem, exits, sourceId);
                }

                this.lastLevel = nodes[nodes.length - 1].level;

                nodes = nodes.sort((a, b) => a.level - b.level);

                this.nodes = nodes;
                this.links = links;
                this.exits = exits;
            },

            findOrCreateSource (visitorsFlowItem, nodes ) {
                let source = nodes.find(node => {
                    let source;
                    if (visitorsFlowItem.level === 1) {
                        source = visitorsFlowItem.parameter === node.name;
                    } else {
                        source = visitorsFlowItem.source_url === node.name;
                    }
                    return source && node.level === visitorsFlowItem.level;
                });

                if (source) {
                    return source.id;
                }

                let sourceId;
                if (nodes.length === 0) {
                    sourceId = 1;
                } else {
                    sourceId = nodes[nodes.length - 1].id + 1;
                }

                let column = nodes.filter(node => node.level === visitorsFlowItem.level);

                if (column.length === 4) {
                    nodes.push({
                        id: sourceId,
                        name: '...',
                        level: visitorsFlowItem.level
                    });
                    return sourceId;
                }

                if (column.length > 4) {
                    return column[column.length - 1].id;
                }

                if (visitorsFlowItem.level === 1) {
                    nodes.push({
                        id: sourceId,
                        name: visitorsFlowItem.parameter,
                        level: visitorsFlowItem.level
                    });
                } else {
                    nodes.push({
                        id: sourceId,
                        name: visitorsFlowItem.source_url,
                        level: visitorsFlowItem.level
                    });
                }

                return sourceId;
            },

            findOrCreateTarget (visitorsFlowItem, nodes) {
                let target = nodes.find(node => {
                    return visitorsFlowItem.target_url === node.name && node.level === visitorsFlowItem.level + 1;
                });

                if (target) {
                    return target.id;
                }

                let targetId = nodes[nodes.length - 1].id + 1;

                nodes.push({
                    id: targetId,
                    name: visitorsFlowItem.target_url,
                    level: visitorsFlowItem.level + 1
                });

                return targetId;
            },

            findOrCreateLink (visitorsFlowItem, links, sourceId, targetId) {
                let linkIndex = links.findIndex(link => {
                    return link.level === visitorsFlowItem.level && // level condition is redundant?
                        link.source === sourceId &&
                        link.target === targetId;
                });

                if (linkIndex !== -1) {
                    links[linkIndex].value += visitorsFlowItem.views;
                    return links[linkIndex].id;
                }

                links.push({
                    source: sourceId,
                    target: targetId,
                    value: visitorsFlowItem.views,
                    level: visitorsFlowItem.level
                });

                return links.length - 1;
            },

            findOrCreateExit (visitorsFlowItem, exits, sourceId) {
                let exitIndex = exits.findIndex(exit => exit.source === sourceId);

                if (exitIndex !== -1) {
                    exits[exitIndex].value += visitorsFlowItem.exit_count;
                    return exits[exitIndex].id;
                }

                exits.push({
                    source: sourceId,
                    value: visitorsFlowItem.exit_count,
                    index: sourceId - 1
                });

                return exits.length - 1;
            },

            addInteraction () {
                this.$emit("add-interaction", this.lastLevel);
            },

            drawDiagram () {
                d3.select('#visitors-flow-diagram')
                    .remove();
                d3.select('.diagram-tooltip')
                    .remove();

                const _sankey = sankey()
                    .nodeSort(null)
                    .nodeWidth(160)
                    .nodeId(d => d.id)
                    .nodePadding(10)
                    .nodeAlign(sankeyLeft)
                    .extent([
                        [1, 1],
                        [this.width - 1, this.height - 5]
                    ]);

                const svg = d3.select('#visitors-flow-container')
                    .insert('svg', ':first-child')
                    .attr('id', 'visitors-flow-diagram')
                    .attr("viewBox", `0 -40 ${this.width + 60} ${this.height + 80}`)
                    .style("width", "100%")
                    .style("min-width", this.width / 1.5)
                    .style("height", "auto");

                const {
                    nodes,
                    links
                } = _sankey({ nodes: this.nodes, links: this.links });

                svg.append("g")
                    .selectAll("rect")
                    .data(nodes)
                    .join("rect")
                    .attr("x", d => d.x0)
                    .attr("y", d => d.y0)
                    .attr("rx", "4")
                    .attr("ry", "4")
                    .attr("height", d => d.y1 - d.y0)
                    .attr("width", d => d.x1 - d.x0)
                    .attr("fill", '#526ede')
                    .attr("class", "node")
                    .attr("id", d => `node-${d.index}`)
                    .on("mouseover", (node, i, nodes) => {
                        d3.selectAll("rect")
                            .style("opacity", "0.2");
                        d3.selectAll("path")
                            .attr("stroke-opacity", ".2");

                        this.highlightLeftSide(d3.select(nodes[i]));
                        this.highlightRightSide(d3.select(nodes[i]));
                    })
                    .on("mouseleave", () => {
                        d3.selectAll("rect")
                            .style("opacity", "1");

                        d3.selectAll("path")
                            .attr("stroke-opacity", ".5");
                    });

                const tooltip = d3.select("#visitors-flow-container")
                    .append("div")
                    .attr("class", "diagram-tooltip");

                svg.append("g")
                    .attr("fill", "none")
                    .selectAll("g")
                    .data(links)
                    .join("path")
                    .attr("d", sankeyLinkHorizontal())
                    .attr("class", "link")
                    .attr("id", d => `link-${d.index}`)
                    .attr("stroke", '#829afa')
                    .attr("stroke-opacity", ".5")
                    .attr("stroke-width", d => Math.max(1, d.width / 1.5))
                    .on("mouseover", (d, i, links) => {
                        tooltip.text(`${d.source.name} → ${d.target.name}, ${d.value}`)
                            .style("visibility", "visible");

                        d3.selectAll("rect")
                            .style("opacity", ".2");
                        d3.selectAll("path")
                            .attr("stroke-opacity", ".2");

                        const link = d3.select(links[i]);

                        link.attr("stroke-opacity", "1");
                        this.highlightRightSide(d3.select(`#node-${link.data()[0].target.index}`));
                        this.highlightLeftSide(d3.select(`#node-${link.data()[0].source.index}`));
                    })
                    .on("mouseleave", function () {
                        tooltip.style("visibility", "hidden");

                        d3.selectAll("rect")
                            .style("opacity", "1");
                        d3.selectAll("path")
                            .attr("stroke-opacity", ".5");
                    })
                    .on("mousemove", () => {
                        tooltip.style("left", (d3.event.pageX + 20) + "px")
                            .style("top", (d3.event.pageY - 40) + "px");
                    });

                svg.append("g")
                    .attr("fill", "none")
                    .selectAll("rect")
                    .data(this.exits)
                    .join("path")
                    .attr("d", d => {
                        let node = nodes.find((node) => node.id === d.source);

                        let mx = node.x1;
                        let my = node.y1 - d.value / 2 - 2;

                        return `M ${mx} ${my} a 25 40 0 0 1 25 40`;
                    })
                    .attr("class", "exits")
                    .attr("id", d => `exit-${d.index}`)
                    .attr("stroke", "#fa514a")
                    .attr("stroke-opacity", ".5")
                    .attr("stroke-width", d => d.value)
                    .on("mouseover", (d, i, exits) => {
                        tooltip.text(`${d.value} drop-offs`)
                            .style("visibility", "visible");

                        d3.selectAll("rect")
                            .style("opacity", ".2");
                        d3.selectAll("path")
                            .attr("stroke-opacity", ".2");

                        const exit = d3.select(exits[i]);

                        exit.attr("stroke-opacity", "1");
                        this.highlightLeftSide(d3.select(`#node-${exit.data()[0].index}`));
                    })
                    .on("mouseleave", () =>  {
                        tooltip.style("visibility", "hidden");

                        d3.selectAll("rect")
                            .style("opacity", "1");
                        d3.selectAll("path")
                            .attr("stroke-opacity", ".5");
                    })
                    .on("mousemove", () => {
                        tooltip.style("left", (d3.event.pageX + 20) + "px")
                            .style("top", (d3.event.pageY - 40) + "px");
                    });

                svg.append("g")
                    .style("font", "14px Gilroy")
                    .style("fill", "white")
                    .selectAll("text")
                    .data(nodes)
                    .join("text")
                    .attr("x", d => d.x1 - 80)
                    .attr("y", d => (d.y1 + d.y0) / 2)
                    .attr("dy", "0.35em")
                    .attr("text-anchor", "middle")
                    .attr("class", "node-text")
                    .attr("id", d => `node-text-${d.index}`)
                    .text(d => `${d.name}, ${d.value}`)
                    .on("mouseover", (text, i, texts) => {
                        const index = d3.select(texts[i]).data()[0].index;
                        d3.select(`#node-${index}`)
                            .dispatch("mouseover");
                    });

                svg.append("g")
                    .selectAll("rect")
                    .data(nodes.filter((node, i, nodes) => {
                        return nodes[i - 1] && node.level !== 1 && node.level !== nodes[i - 1].level;
                    }))
                    .join("text")
                    .attr("x", d => d.x1 - 80)
                    .attr("y", -20)
                    .attr("class", "title")
                    .attr("text-anchor", "middle")
                    .text((d) => {
                        if (this.titles[d.depth - 1]) {
                            return this.titles[d.depth - 1];
                        }
                        return `${[d.depth]}th Interaction`;
                    });
            },

            highlightRightSide (node) {
                node.style("opacity", "1");

                const nodeData = node.data()[0];

                d3.select(`#exit-${nodeData.index}`)
                    .attr("stroke-opacity", "1");

                nodeData.sourceLinks
                    .forEach((link) => {
                        d3.select(`#link-${link.index}`)
                            .attr("stroke-opacity", ".9");

                        let next = d3.select(`#node-${link.target.index}`);
                        if (next) {
                            this.highlightRightSide(next);
                        }
                    });
            },

            highlightLeftSide (node) {
                node.style("opacity", "1");

                const nodeData = node.data()[0];

                d3.select(`#exit-${nodeData.index}`)
                    .attr("stroke-opacity", "1");

                nodeData.targetLinks
                    .forEach((link) => {
                        d3.select(`#link-${link.index}`)
                            .attr("stroke-opacity", ".9");

                        let next = d3.select(`#node-${link.source.index}`);
                        if (next) {
                            this.highlightLeftSide(next);
                        }
                    });
            }
        },
    };
</script>

<style lang="scss">
    #visitors-flow-container {
        display: flex;
        align-items: center;
        max-width: 70vw;
        overflow-x: auto;
        transition: all .5s;
        margin-top: 1rem;

        &::-webkit-scrollbar {
            background-color:#fff;
            width:16px
        }

        &::-webkit-scrollbar-track {
             background-color:#fff
        }

        &::-webkit-scrollbar-track:hover {
            background-color:#f4f4f4
        }

        &::-webkit-scrollbar-thumb {
            background-color:#babac0;
            border-radius:16px;
            border:5px solid #fff
        }

        &::-webkit-scrollbar-thumb:hover {
            background-color:#a0a0a5;
            border:4px solid #f4f4f4
        }

        &::-webkit-scrollbar-button {
            display:none
        }

        #visitors-flow-diagram {
            .link {
                transition: all .4s;
                cursor: pointer;
            }

            .title{
                font-size: 1rem;
            }

            .node {
                transition: all .4s;
                cursor: pointer;
            }

            .node-text {
                cursor: pointer;
            }
        }

        .diagram-tooltip {
            visibility: hidden;
            box-shadow: 2px 10px 16px rgba(0, 0, 0, 0.16);
            position: fixed;
            text-align: center;
            padding: 8px;
            font-size: 12px;
            background: white;
            border: 1px solid rgba(60, 87, 222, 0.52);
            border-radius: 6px;
            pointer-events: none;
            color: rgba(0, 0, 0, 0.8)
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-left: 1rem;

            .step-button {
                &:focus {
                    outline: 0;
                }

                .step-arrow {
                    color: #526ede;
                    transition: all .5s;

                    &:hover {
                        color: #6a7bde;
                    }

                    &:active {
                        color: #4061de;
                    }
                }

                &:disabled {
                    .step-arrow {
                        color: #afafaf;
                    }
                }
            }
        }
    }
</style>
