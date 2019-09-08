<template>
    <div id="visitors-flow-container">
        <div class="overflow" />
        <svg id="visitors-flow-diagram" />
        <div class="step">
            <button
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
    import { sankey, sankeyLinkHorizontal } from "d3-sankey";

    export default {
        name: "VisitorsFlowDiagram",
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
                nodes: [
                    { id: 1, name: 'United States' },
                    { id: 2, name: 'United Kingdom' },
                    { id: 3, name: 'Japan' },
                    { id: 4, name: 'Canada'},
                    { id: 5, name: '...'},

                    { id: 6, name: '/home' },
                    { id: 7, name: '/market' },
                    { id: 8, name: '/about' },
                    { id: 9, name: '/contacts' },
                    { id: 10, name: '(> 100 more pages)'},

                    { id: 11, name: '/sign-in' },
                    { id: 12, name: '/basket' },
                    { id: 13, name: '/profile' },
                    { id: 14, name: '/sales' },
                    { id: 15, name: '(> 100 more pages)'},
                ],
                links: [],
                exits: []
            };
        },
        computed: {
            width () {
                return this.nodes.length / 5 * 400;
            }
        },
        mounted() {
            this.drawDiagram();
        },
        methods: {
            createLinks () {
                this.links = [];
                let lastNodeId = this.nodes.slice(-1)[0].id;

                for (let coef = 1, sourceInd = 0; sourceInd < lastNodeId - 5; sourceInd++) {
                    let sourceId = this.nodes[sourceInd].id;

                    for (let targetInd = 0; targetInd < 5; targetInd++) {
                        let targetId = this.nodes[targetInd + 5 * coef].id;
                        let value = Math.floor(Math.random() * Math.floor(100));
                        let link = { source: sourceId, target: targetId, value: value };
                        this.links.push(link);
                    }

                    if (sourceId % 5 === 0) {
                        coef++;
                    }
                }
            },

            createExits() {
                this.exits = [];
                let lastNodeId = this.nodes.slice(-1)[0].id;

                for (let sourceInd = 5; sourceInd < lastNodeId; sourceInd++) {
                    let sourceId = this.nodes[sourceInd].id;
                    let value = Math.floor(Math.random() * 50);
                    let exit = { source: sourceId, value: value, index: sourceId - 1 };
                    this.exits.push(exit);
                }
            },

            addInteraction () {
                let lastNodeId = this.nodes.slice(-1)[0].id;

                for (let i = lastNodeId + 1; i < lastNodeId + 6; i++) {
                    this.nodes.push({ id: i, name: `/link${i}`});
                }

                this.drawDiagram();

                d3.transition()
                    .select('#visitors-flow-container')
                    .tween("scroll", function () {
                        this.scrollLeft += this.scrollWidth;
                    });
            },

            drawDiagram () {
                d3.select('#visitors-flow-diagram')
                    .remove();
                d3.select('.diagram-tooltip')
                    .remove();

                this.createLinks();
                this.createExits();

                const _sankey = sankey()
                    .nodeSort(null)
                    .nodeWidth(160)
                    .nodeId(d => d.id)
                    .nodePadding(10)
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
                    .attr("stroke-width", d => Math.max(1, d.width))
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
                    .attr("class", "drops")
                    .attr("id", d => `drop-${d.index}`)
                    .attr("stroke", "#fa514a")
                    .attr("stroke-opacity", ".5")
                    .attr("stroke-width", d => d.value)
                    .on("mouseover", (d, i, drops) => {
                        tooltip.text(`${d.value} drop-offs`)
                            .style("visibility", "visible");

                        d3.selectAll("rect")
                            .style("opacity", ".2");
                        d3.selectAll("path")
                            .attr("stroke-opacity", ".2");

                        const drop = d3.select(drops[i]);

                        drop.attr("stroke-opacity", "1");
                        this.highlightLeftSide(d3.select(`#node-${drop.data()[0].index}`));
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
                    .data(nodes.filter((node) => {
                        return node.id !== 5 && node.id % 5 === 0;
                    }))
                    .join("text")
                    .attr("x", d => d.x1 - 80)
                    .attr("y", -20)
                    .attr("class", "title")
                    .attr("text-anchor", "middle")
                    .text((d) => {
                        if (this.titles[d.depth]) {
                            return this.titles[d.depth];
                        }
                        return `${[d.depth]}th Interaction`;
                    });
            },

            highlightRightSide (node) {
                node.style("opacity", "1");

                const nodeData = node.data()[0];

                d3.select(`#drop-${nodeData.index}`)
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

                d3.select(`#drop-${nodeData.index}`)
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
            }
        }
    }
</style>
