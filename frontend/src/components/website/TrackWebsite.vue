<template>
    <pre>
    <code>
    &lt;!-- Global site tag (metrica.js) - Metrica Analytics --&gt;
    &lt;script async src='https://stage.metrica.fun/metrica.js?tracking_id={{ trackingNumber }}'&gt;&lt;/script&gt;
    &lt;script&gt;
        window._metricaTrackingConfig = window._metricaTrackingConfig || [];
        function mtag() {
            _metricaTrackingConfig.push(arguments);
        }
        mtag('dateStart', new Date());
        mtag('tracking_id', {{ trackingNumber }});
    &lt;/script&gt;
    </code>
    </pre>
</template>
<script>
    export default {
        name: 'TrackWebsite',
        props: {
            trackingNumber: {
                type: [Number, String],
                required: true
            }
        }
    };
</script>
<style lang="scss" scoped>
        code {
            color: black;
            padding: 0 10px;
        }
</style>
