module.exports = {
    css: {
        loaderOptions: {
        sass: {
            data: `@import "~@/sass/main.scss"`,
        },
        },
    },
    devServer: {
        host: '0.0.0.0',
        disableHostCheck: true,
        overlay: {
            warnings: true,
            errors: true
        }
    },
    configureWebpack: (config) => {
        config.devtool = 'source-map'
    },
}
