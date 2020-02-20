module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/essential',
    '@vue/airbnb',
  ],
  parserOptions: {
    parser: 'babel-eslint',
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'comma-dangle': 'off',
    'quotes': 'off',
    'no-unused-vars': 'off',
    'indent': 'off',
    'semi': 'off',
    'max-len': 'off',
    'eol-last': 'off',
    'no-undef': 'off',
    'no-param-reassign': 'off',
    'prefer-template': 'off',
    'prefer-const': 'off',
    'no-var': 'off',
    'spaced-comment': 'off'
  },
};
