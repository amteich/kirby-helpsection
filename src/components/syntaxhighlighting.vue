<script>

import Prism from 'prismjs';
import '../vendor/prism.css';

export default {
  init() {
    const codeBlocks = document.querySelectorAll('pre code[class^="language-"], pre code[class*=" language-"], pre.code > code');
    const languageClassPattern = /(?:^| )language(-[a-z])( |$)*/i;

    if (codeBlocks.length > 0) {

      for (let code, i = 0, l = codeBlocks.length; i < l && (code = codeBlocks[i]); i++) {
        if (!languageClassPattern.test(code.className)) {
          code.classList.add('language-plaintext');
        }
      }

      this.initPrismLanguages();
    }
  },
  initPrismLanguages() {

    Prism.manual = true;

    Prism.languages.kirbytext = Prism.languages.extend('markdown', {});

    Prism.languages.insertBefore('kirbytext', 'prolog', {
      'kirbytag': {
        pattern: /\([a-z0-9_-]+:.*?\)/i,
        inside: {
          'kirbytag-bracket': /^\(|\)$/,

          'kirbytag-name': {
            pattern: /^[a-z0-9_-]+:/i,
          },

          'kirbytag-attr': {
            pattern: /([^:]\s+)[a-z0-9_-]+:/i,
            lookbehind: true,
          },
        }
      },
    });

    Prism.highlightAll();
  }
}

</script>

<style>
.token.kirbytag-bracket {
  color: #d16464;
}

.token.kirbytag-name,
.token.kirbytag-attr {
  color: #de935f;
}

pre[class*="language-"] {
  margin-bottom: 1.5rem;
  font-size: 0.8rem;
}
</style>
