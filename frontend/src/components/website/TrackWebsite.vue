<template>
    <pre>
    <code>
    &lt;!-- Global site tag (gtag.js) - Google Analytics --&gt;
    &lt;script async src='https://www.googletagmanager.com/gtag/js?id={{ trackingNumber }}'&gt;&lt;/script&gt;
    &lt;script&gt;
      window.dataLayer = window.dataLayer || [];
        function gtag() {
          dataLayer.push(arguments);
        }
      gtag('js', new Date());
      gtag('config', {{ trackingNumber }});
    &lt;/script&gt;
    </code>
    </pre>
</template>
<script>
    export default {
        name: 'TrackWebsite',
        props: {
            trackingNumber: {
                type: Number,
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
