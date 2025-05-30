// cspell:ignore testcases
const path = require('node:path');
const { globSync } = require('glob');

// Find directories which have Nightwatch tests in them.
const regex = /(.*\/?tests\/?.*\/Nightwatch)\/.*/g;
const collectedFolders = {
  Tests: [],
  Commands: [],
  Assertions: [],
  Pages: [],
};
const searchDirectory = process.env.DRUPAL_NIGHTWATCH_SEARCH_DIRECTORY || '';
const defaultIgnore = ['vendor/**'];

globSync('**/tests/**/Nightwatch/**/*.js', {
  cwd: path.resolve(process.cwd(), `../${searchDirectory}`),
  follow: true,
  ignore: process.env.DRUPAL_NIGHTWATCH_IGNORE_DIRECTORIES
    ? process.env.DRUPAL_NIGHTWATCH_IGNORE_DIRECTORIES.split(',').concat(
        defaultIgnore,
      )
    : defaultIgnore,
})
  .sort()
  .forEach((file) => {
    let m = regex.exec(file);
    while (m !== null) {
      // This is necessary to avoid infinite loops with zero-width matches.
      if (m.index === regex.lastIndex) {
        regex.lastIndex += 1;
      }

      const key = `../${m[1]}`;
      Object.keys(collectedFolders).forEach((folder) => {
        if (file.includes(`Nightwatch/${folder}`)) {
          collectedFolders[folder].push(`${searchDirectory}${key}/${folder}`);
        }
      });
      m = regex.exec(file);
    }
  });

// Remove duplicate folders.
Object.keys(collectedFolders).forEach((folder) => {
  collectedFolders[folder] = Array.from(new Set(collectedFolders[folder]));
});

module.exports = {
  src_folders: collectedFolders.Tests,
  output_folder: process.env.DRUPAL_NIGHTWATCH_OUTPUT,
  custom_commands_path: collectedFolders.Commands,
  custom_assertions_path: collectedFolders.Assertions,
  page_objects_path: collectedFolders.Pages,
  globals_path: 'globals.js',
  selenium: {
    start_process: false,
  },
  test_settings: {
    default: {
      globals: {
        defaultTheme: 'olivero',
        adminTheme: 'claro',
      },
      selenium_port: process.env.DRUPAL_TEST_WEBDRIVER_PORT,
      selenium_host: process.env.DRUPAL_TEST_WEBDRIVER_HOSTNAME,
      default_path_prefix: process.env.DRUPAL_TEST_WEBDRIVER_PATH_PREFIX || '',
      desiredCapabilities: {
        browserName: 'chrome',
        acceptSslCerts: true,
        'goog:chromeOptions': {
          w3c: !!process.env.DRUPAL_TEST_WEBDRIVER_W3C,
          args: process.env.DRUPAL_TEST_WEBDRIVER_CHROME_ARGS
            ? process.env.DRUPAL_TEST_WEBDRIVER_CHROME_ARGS.split(' ')
            : [],
        },
      },
      screenshots: {
        enabled: true,
        on_failure: true,
        on_error: true,
        path: `${process.env.DRUPAL_NIGHTWATCH_OUTPUT}/screenshots`,
      },
      end_session_on_fail: false,
      skip_testcases_on_fail: false,
    },
    local: {
      webdriver: {
        start_process: process.env.DRUPAL_TEST_CHROMEDRIVER_AUTOSTART,
        port: process.env.DRUPAL_TEST_WEBDRIVER_PORT,
        cli_args: process.env.DRUPAL_TEST_WEBDRIVER_CLI_ARGS
          ? process.env.DRUPAL_TEST_WEBDRIVER_CLI_ARGS.split(' ')
          : [],
      },
      desiredCapabilities: {
        browserName: 'chrome',
        acceptSslCerts: true,
        'goog:chromeOptions': {
          w3c: !!process.env.DRUPAL_TEST_WEBDRIVER_W3C,
          args: process.env.DRUPAL_TEST_WEBDRIVER_CHROME_ARGS
            ? process.env.DRUPAL_TEST_WEBDRIVER_CHROME_ARGS.split(' ')
            : [],
        },
      },
      screenshots: {
        enabled: true,
        on_failure: true,
        on_error: true,
        path: `${process.env.DRUPAL_NIGHTWATCH_OUTPUT}/screenshots`,
      },
      end_session_on_fail: false,
      skip_testcases_on_fail: false,
    },
  },
};
