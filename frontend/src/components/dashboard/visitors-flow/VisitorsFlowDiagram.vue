<template>
    <div id="visitors-flow-container">
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
                links: []
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

            addInteraction () {
                let lastNodeId = this.nodes.slice(-1)[0].id;
                for (let i = lastNodeId + 1; i < lastNodeId + 6; i++) {
                    this.nodes.push({ id: i, name: `/link${i}`});
                }
                this.drawDiagram();

                d3.transition()
                    .select('#visitors-flow-container')
                    .duration(3000)
                    .tween("scroll", (() => {
                        const container = document.querySelector('#visitors-flow-container');
                        container.scrollLeft = container.scrollWidth;
                    })());
            },

            drawDiagram () {
                d3.select('#visitors-flow-diagram')
                    .remove();
                d3.select('.diagram-tooltip')
                    .remove();
                this.createLinks();

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
                    .attr("viewBox", `0 -40 ${this.width} ${this.height + 40}`)
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
                    .attr("rx", "5")
                    .attr("ry", "5")
                    .attr("height", d => d.y1 - d.y0)
                    .attr("width", d => d.x1 - d.x0)
                    .attr("fill", () => '#526ede');

                const link = svg.append("g")
                    .attr("fill", "none")
                    .attr("stroke-opacity", 0.5)
                    .selectAll("g")
                    .data(links)
                    .join("g")
                    .style("mix-blend-mode", "multiply");

                link.append("path")
                    .attr("d", sankeyLinkHorizontal())
                    .attr("class", "link")
                    .attr("stroke", () => '#829afa')
                    .attr("stroke-width", d => Math.max(1, d.width));

                const tooltip = d3.select("#visitors-flow-container")
                    .append("div")
                    .attr("class", "diagram-tooltip");

                link.on("mouseover", (d) => {
                    tooltip.text(`${d.source.name} → ${d.target.name}, ${d.value}`)
                        .style("visibility", "visible");
                })
                    .on("mouseleave", () => tooltip.style("visibility", "hidden"))
                    .on("mousemove", function () {
                        tooltip
                            .style("left", (d3.event.pageX + 20) + "px")
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
                    .text(d => `${d.name}, ${d.value}`);

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
            }
        }
    };
</script>

<style lang="scss">
    #visitors-flow-container {
        display: flex;
        align-items: center;
        max-width: 70vw;
        overflow-x: auto;
        transition: all .5s;

        #visitors-flow-diagram {

            .link:hover {
                stroke-opacity: 1;
                cursor: pointer;
            }

            .title{
                font-size: 1rem;
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