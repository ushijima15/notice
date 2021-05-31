module.exports = {
  root: true,
  env: {
    browser: true,
  },
  parserOptions: {
    parser: 'babel-eslint',
  },
  extends: [
    // add more generic rulesets here, such as:
    'standard',
    'eslint:recommended',
    'plugin:vue/recommended',
    'plugin:prettier/recommended',
  ],
  plugins: [
    'vue',
    'prettier', // prettierをESLintと併用します
  ],
  globals: {
    'window': true,
    'Vue': true,
    'BootstrapVue': true,
    'axios': true
  },
  rules: {
    // override/add rules settings here, such as:
    // ESLintが使用する整形ルールのうち、自分がoffにしたいルールなどを指定する
    'vue/no-v-html': 'off',         // v-htmlの使用について
    // 'vue/prop-name-casing': 'off',  // Propsの変数の命名規則について
    'vue/require-prop-types': 'off',
    'no-console': 'off',            // console.log()の使用について
    'no-unused-vars': 'off',        // 使われていない変数について
    'camelcase': 'off',             // camelcaseについて
    // この先はPrettierのルール
    "prettier/prettier": [ 
      "error",
      {
        printWidth: 120,
        tabWidth: 2,
        useTabs: false,
        singleQuote: true,
        trailingComma: 'all',
        bracketSpacing: true,
        arrowParens: 'avoid',
        semi: false,
      },
    ]
  }
}