module.exports = {
  browserSync: {
    port: 3998,
    proxy: {
      target: 'starter.loc',
    },
  },
  webpack: {
    dev: require('./webpack.dev'),
    prod: require('./webpack.prod'),
  },
};
