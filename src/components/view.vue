<template>
  <main class="mgfhelp">
    <nav class="mgfhelp__panel mgfhelp__sections">
      <div class="mgfhelp__scrollarea">
        <section
          v-for="(heading, headingindex) in pages"
          :key="headingindex"
        >
          <h2>{{ heading.content.title }}</h2>

          <ul>
            <li
              v-for="(subpage, subpageindex) in heading.children"
              :key="subpageindex">
              <a
                :aria-current="subpage.slug === currentTopLevelSlug"
                @click.stop="clickPrimaryNav(subpage)"
              >
                {{ subpage.content.title }}
              </a>
            </li>
          </ul>
        </section>
      </div>
    </nav>
    <nav v-if="navSecondary != null" class="mgfhelp__panel mgfhelp__entries">
      <div class="mgfhelp__scrollarea">
        <ul>
          <li
            v-for="(item, index) in navSecondary"
            :key="index">
            <a
                :aria-current="item.slug === currentSecondLevelSlug"
                @click.stop="clickSecondaryNav(item)"
              >
              <span>
                <strong>{{ item.content.title }}</strong>
                <small v-if="item.content.excerpt" v-html="item.content.excerpt"></small>
              </span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <article class="mgfhelp__panel mgfhelp__main">
      <div class="mgfhelp__scrollarea">
        <div class="mgfhelp__main__inner">
          <k-text v-if="content != null">
            <h1>{{ content.title }}</h1>
            <div class="intro" v-html="content.excerpt"></div>
            <div v-html="content.text"></div>
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
      pages: null,
      currentTopLevelSlug: null,
      currentSecondLevelSlug: null,
      navSecondary: null,
      content: null,
    };
  },
  computed: {
  },
  updated: function() {
    Syntaxhighlighting.init();
  },
  mounted() {
    // console.log (window.location.hash);
    var panelview = document.querySelector(".k-panel-view");
    panelview.classList.add('mgfhelp-overflow-hidden');

    this.$api.get('mgf/documentation/pages').then(response => {
      this.pages = response.pages;
      this.openFirstFoundPage(this.pages);
    });
  },
  methods: {
    clickPrimaryNav(subpage) {
      if ('children' in subpage) {
        this.navSecondary = subpage.children;
      }
      else {
        this.navSecondary = null;
      }
      if ('content' in subpage) {
        this.content = subpage.content;
      }
      else {
        this.content = null;
      }

      this.currentSecondLevelSlug = null;
      this.currentTopLevelSlug = subpage.slug;
    },
    clickSecondaryNav(subpage) {
      this.content = subpage.content;
      this.currentSecondLevelSlug = subpage.slug;
    },
    openFirstFoundPage (pages) {
      // console.log (pages);
      for (var key in pages) {
        if (typeof pages[key]['children'] === 'undefined') {
          this.content = pages[key]['content'];
          this.currentTopLevelSlug = pages[key].slug;
          return true;
        }
        else {
          return this.openFirstFoundPage(pages[key]['children']);
        }
      }
    }
  }
}

</script>

<style lang="scss">

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
    flex-basis: 11rem;
    flex-grow: 0;

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
    flex-grow: 0;
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

    h1, h2, h3, h4, h5, h6 {
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

  .mgfhelp__main__inner {
    padding: 3rem;
  }

.mgfhelp-overflow-hidden {
  overflow: hidden;
}

</style>
