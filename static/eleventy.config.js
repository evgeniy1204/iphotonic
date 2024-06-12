const fs = require('fs');
const postcss = require('postcss');
const postcssImport = require('postcss-import');
const postcssMediaMinmax = require('postcss-media-minmax');
const postcssSortMediaQueries = require('postcss-sort-media-queries');
const autoprefixer = require('autoprefixer');
const postcssCsso = require('postcss-csso');
const yaml = require('js-yaml');

module.exports = (config) => {
  // YAML

  config.addDataExtension('yml', (contents) => {
    return yaml.load(contents);
  });

  // CSS

  const styles = [
    './src/styles/index.css',
  ];

  config.addTemplateFormats('css');

  config.addExtension('css', {
    outputFileExtension: 'css',
    compile: async (content, path) => {
      if (!styles.includes(path)) {
        return;
      }

      return async () => {
        let output = await postcss([
          postcssImport,
          postcssMediaMinmax,
          postcssSortMediaQueries,
          autoprefixer,
          postcssCsso,
        ]).process(content, {
          from: path,
        });

        return output.css;
      }
    }
  });

  // Passthrough copy

  [
    'src/styles',
  ].forEach(
    path => config.addPassthroughCopy(path)
  );

  // Config

  return {
    dir: {
      data: 'data',
      input: 'src/styles',
      output: '../public/styles/app',
      includes: 'includes',
      layouts: 'layouts',
    },
    dataTemplateEngine: 'njk',
    htmlTemplateEngine: 'njk',
    templateFormats: [
      'njk'
    ],
  };
};
