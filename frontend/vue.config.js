
module.exports = {
    css: {
        loaderOptions: {
            sass: {
                data: `@import "~@/scss/variables.scss"`,
            },
        },
        sourceMap: true,
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
        if (process.env.NODE_ENV !== "production") {
            config.devtool = 'source-map';
        }
    },
    chainWebpack: config => {
        ["vue-modules", "vue", "normal-modules", "normal"].forEach((match) => {
            config.module.rule('scss').oneOf(match).use('sass-loader')
                .tap(opt => Object.assign(opt, { data: `@import '~@/scss/variables.scss';` }));
        });
    }
};