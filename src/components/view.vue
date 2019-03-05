<template>
  <main class="mgfhelp">
    <nav v-if="navPrimary != null" v-show="!isMobile || show=='menu'" class="mgfhelp__panel mgfhelp__sections">
      <header class="mgfhelp__header" v-show="isMobile">
        <button @click.stop="show='main'">
          <svg viewBox="0 0 12 12" width="12" height="12"><title>e remove</title><g fill="#111111"><path d="M10.707,1.293a1,1,0,0,0-1.414,0L6,4.586,2.707,1.293A1,1,0,0,0,1.293,2.707L4.586,6,1.293,9.293a1,1,0,1,0,1.414,1.414L6,7.414l3.293,3.293a1,1,0,0,0,1.414-1.414L7.414,6l3.293-3.293A1,1,0,0,0,10.707,1.293Z" fill="#111111"></path></g></svg>
          {{ $t('mgfhelp.close') }}
        </button>
      </header>
      <div class="mgfhelp__scrollarea">
        <section
          v-for="(heading, headingindex) in navPrimary"
          :key="headingindex"
        >
          <h2>{{ heading.title }}</h2>

          <ul>
            <li
              v-for="(subpage, subpageindex) in heading.children"
              :key="subpageindex">
              <a
                :aria-current="currentPageSlug.startsWith(subpage.id)"
                @click.stop="clickPrimaryNav(subpage)"
              >
                {{ subpage.title }}
              </a>
            </li>
          </ul>
        </section>
      </div>
    </nav>
    <nav v-if="navSecondary != null"  v-show="!isMobile || show=='entries'" class="mgfhelp__panel mgfhelp__entries">
      <header class="mgfhelp__header" v-show="isMobile">
        <button @click.stop="show='menu'">
          <svg viewBox="0 0 12 12" width="12" height="12"><title>menu 8</title><g fill="#111111"><path d="M11,9H1a1,1,0,0,0,0,2H11a1,1,0,0,0,0-2Z" fill="#111111"></path> <path d="M11,1H1A1,1,0,0,0,1,3H11a1,1,0,0,0,0-2Z" fill="#111111"></path> <path d="M11,5H1A1,1,0,0,0,1,7H11a1,1,0,0,0,0-2Z" data-color="color-2"></path></g></svg>
          {{ $t('mgfhelp.menu') }}
        </button>
        <button @click.stop="show='main'">
          <svg viewBox="0 0 12 12" width="12" height="12"><title>e remove</title><g fill="#111111"><path d="M10.707,1.293a1,1,0,0,0-1.414,0L6,4.586,2.707,1.293A1,1,0,0,0,1.293,2.707L4.586,6,1.293,9.293a1,1,0,1,0,1.414,1.414L6,7.414l3.293,3.293a1,1,0,0,0,1.414-1.414L7.414,6l3.293-3.293A1,1,0,0,0,10.707,1.293Z" fill="#111111"></path></g></svg>
          {{ $t('mgfhelp.close') }}
        </button>
      </header>
      <div class="mgfhelp__scrollarea">
        <ul>
          <li
            v-for="(item, index) in navSecondary"
            :key="index">
            <a
                :aria-current="item.id === currentPageSlug"
                @click.stop="clickSecondaryNav(item)"
              >
              <span>
                <strong>{{ item.title }}</strong>
                <small v-if="item.content.excerpt" v-html="item.content.excerpt"></small>
              </span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <article class="mgfhelp__panel mgfhelp__main" v-show="show=='main'">
      <div class="mgfhelp__header" v-show="isMobile">
        <button @click.stop="show='menu'">
          <svg viewBox="0 0 12 12" width="12" height="12"><title>menu 8</title><g fill="#111111"><path d="M11,9H1a1,1,0,0,0,0,2H11a1,1,0,0,0,0-2Z" fill="#111111"></path> <path d="M11,1H1A1,1,0,0,0,1,3H11a1,1,0,0,0,0-2Z" fill="#111111"></path> <path d="M11,5H1A1,1,0,0,0,1,7H11a1,1,0,0,0,0-2Z" data-color="color-2"></path></g></svg>
          {{ $t('mgfhelp.menu') }}
        </button>
        <button @click.stop="show='entries'" v-if="navSecondary != null">
          <svg viewBox="0 0 12 12" width="12" height="12"><title>layout grid</title><g fill="#111111"><path d="M10,0H2A2,2,0,0,0,0,2v8a2,2,0,0,0,2,2h8a2,2,0,0,0,2-2V2A2,2,0,0,0,10,0ZM7,2V4H2V2ZM7,7H2V5H7ZM2,8H7v2H2Zm6,2V2h2v8Z" fill="#111111"></path></g></svg>
          {{ $t('mgfhelp.overview') }}
        </button>
      </div>
      <div class="mgfhelp__scrollarea">
        <div class="mgfhelp__main__inner">
          <k-text v-if="content != null" v-html="content">
          </k-text>
        </div>
      </div>
    </article>
  </main>
</template>


<script>
import Syntaxhighlighting from "./syntaxhighlighting.vue";

export default {
  data: function () {
    return {
      navPrimary: null,
      navSecondary: null,
      currentPageSlug: '',
      content: null,
      show: 'main',
      windowWidth: window.innerWidth
    };
  },
  computed: {
    isMobile() {
      return this.windowWidth <= 768
    }
  },
  updated: function() {
    Syntaxhighlighting.init();
  },
  mounted() {

    window.addEventListener('resize', () => {
      this.windowWidth = window.innerWidth
    });

    this.$api.get('mgfagency/helpsection/index').then(response => {
      if (response.status != 'ok') {
        this.content = "<h1>Error</h1><br>" + response.error;
      }
      else {
        this.navPrimary = response.pages;
        this.loadPageContent(response.slug);
      }
    });

    document.querySelector(".k-panel-view").classList.add('k-panel-view--mgfhelp');
  },
  beforeDestroy() {
    document.querySelector(".k-panel-view").classList.remove('k-panel-view--mgfhelp');
  },
  methods: {
    clickPrimaryNav(page) {
      if (page.hasChildren) {
        this.$api.get('pages/' + this.url(page.id, 'children'),
                      { 'select': 'id,title,content' }).then(response => {
          this.navSecondary = response.data;
          this.content = page.rendered;
        });
      }
      else {
        this.content = page.rendered;
        this.navSecondary = null;
      }

      this.currentPageSlug = page.id;
      this.show = 'main';
    },
    clickSecondaryNav(page) {
      this.loadPageContent(page.id);
      this.currentPageSlug = page.id;
      this.show = 'main';
    },
    loadPageContent (slug) {
      this.$api.get('mgfagency/helpsection/page/' + slug).then(response => {
        this.content = response.rendered;
      });
    },
    url(id, path) {
      let url = id.replace(/\//g, "+");

      if (path) {
        url += "/" + path;
      }

      return url;
    },
  }
}

</script>

<style lang="scss">

.k-panel-view--mgfhelp {
  overflow: hidden;
}

.mgfhelp {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  display: flex;
}

  .mgfhelp__panel {
    flex-grow: 1;
    @media only screen and (min-width: 768px) {
      flex-basis: 11rem;
      flex-grow: 0;
    }

    /* flex-basis: 100%; */
    background: #efefef;
    border-right: 1px solid #ddd;

    overflow: hidden;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
  }

  .mgfhelp__sections {
    font-family: SFMono-Regular,Consolas,Liberation Mono,Menlo,Courier,monospace;

    h2 {
      font-size: .875rem;
      margin-bottom: .25rem;
      padding: 0 1.5rem;
      line-height: 1.5;
    }

    section {
      padding: .75rem 0;
    }

    a {
      cursor: pointer;
      font-size: .75rem;
      display: block;
      padding: .25rem 1.5rem;
      width: 100%;

      &[aria-current] {
        background: #ddd;
      }
    }
  }

  .mgfhelp__entries {
    background: #fff;

    flex-basis: 20%;
    min-width: 16rem;

    li {
      position: relative;
      font-size: .75rem;
      border-bottom: 1px solid rgba(0,0,0,.1);

      a {
        cursor: pointer;
        display: block;
        padding: .75rem 1.5rem;
        outline: 0;

        strong {
          font-family: SFMono-Regular,Consolas,Liberation Mono,Menlo,Courier,monospace;
          font-weight: 500;
          display: block;
          font-size: .8rem;
        }

        small {
          color: #777;
          font-size: .75rem;
          margin-top: 5px;
          display: block;
        }

        &[aria-current] {
          background: #ddd;
        }
      }
    }

  }

  .mgfhelp__scrollarea {
    flex-grow: 1;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .mgfhelp__main {
    background: #fff;
    flex-grow: 1;
    flex-shrink: 1;
    min-width: 20rem;

    a {
      color: #008DCE;
      text-decoration: none;

      &:hover {
        color: #006a9b;
      }
    }

    h1, h2, h3, h4, h5, h6, figure, table {
      margin-bottom: 1rem;
    }

    h2, h3, h4, h5, h6 {
      margin-top: 2rem;
    }

    .intro {
      font-size: 1.5rem;
      color: rgba(60,67,80,.8);
      max-width: 35rem;
    }

    img {
      max-width: 100%;
    }
  }

  .mgfhelp__header {
    height: 2.5rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    padding: 0 1.5rem;
    border-bottom: 1px solid #ddd;
    justify-content: space-between;

    button {
      font: inherit;
      display: flex;
      align-items: center;
      font-size: .875rem;
      background: none;
      border: 0;
      cursor: pointer;

      svg {
        margin-right: .5rem;
      }
    }
  }

  .mgfhelp__main__inner {
    padding: 1.5rem;

    @media only screen and (min-width: 768px) {
      padding: 3rem;
    }
  }

</style>
