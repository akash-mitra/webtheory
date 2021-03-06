(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["PageEditor"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorContent_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorContent.vue */ "./resources/js/components/PageEditorContent.vue");
/* harmony import */ var _PageEditorSeo_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorSeo.vue */ "./resources/js/components/PageEditorSeo.vue");
/* harmony import */ var _PageEditorSetting_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PageEditorSetting.vue */ "./resources/js/components/PageEditorSetting.vue");
/* harmony import */ var _PageEditorGallery_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./PageEditorGallery.vue */ "./resources/js/components/PageEditorGallery.vue");
/* harmony import */ var _PageEditorMenu_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./PageEditorMenu.vue */ "./resources/js/components/PageEditorMenu.vue");
/* harmony import */ var _PageEditorContentBlocks_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./PageEditorContentBlocks.vue */ "./resources/js/components/PageEditorContentBlocks.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    PageEditorContent: _PageEditorContent_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    PageEditorSeo: _PageEditorSeo_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    PageEditorSetting: _PageEditorSetting_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    PageEditorGallery: _PageEditorGallery_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    PageEditorMenu: _PageEditorMenu_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    PageEditorContentBlocks: _PageEditorContentBlocks_vue__WEBPACK_IMPORTED_MODULE_5__["default"]
  },
  data: function data() {
    return {
      id: 0,
      title: null,
      intro: null,
      metakey: null,
      metadesc: null,
      category_id: 1,
      media: null,
      status: 'Draft',
      contents: [],
      tab: 'content',
      isSaving: false,
      errors: {
        title: [],
        summary: [],
        metadesc: [],
        metakey: []
      },
      maxDisplayOrder: 1
    };
  },
  created: function created() {
    var _this = this;

    util.ajax('get', '/api/pages/' + this.$route.params.id, {}, function (data) {
      _this.id = data.id;
      _this.title = data.title;
      _this.intro = data.summary;
      _this.metakey = data.metakey;
      _this.metadesc = data.metadesc;
      _this.category_id = data.category_id;
      _this.status = data.status;
      _this.media = data.media;
      _this.contents = data.content;
      _this.maxDisplayOrder = 0;

      for (var i = 0; i < _this.contents.length; i++) {
        var m = _this.contents[i].display_order;

        if (m > _this.maxDisplayOrder) {
          _this.maxDisplayOrder = m;
        }
      }
    }); // this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000)
  },
  // end of created
  methods: {
    isNewPage: function isNewPage() {
      return typeof this.$route.params.id === 'undefined';
    },
    addContentBlock: function addContentBlock(type) {
      console.log(type);
      type = type.toLowerCase();
      this.contents.push({
        type: type,
        body_json: null,
        display_order: this.maxDisplayOrder + 1
      });
      this.maxDisplayOrder++;
    },
    isValid: function isValid(showError) {
      if (typeof showError === 'undefined') showError = false;

      if (!this.title) {
        showError && util.notifyError('Page has no title', 'Provide a title to save this page');
        return false;
      }

      if (this.title.length >= 100) {
        showError && util.notifyError('Page title too long!', 'Keep page title within maximum 100 characters.');
        return false;
      }

      if (!this.intro) {
        showError && util.notifyError('Provide an Introduction', 'Write a few lines of intro for this page before saving.');
        return false;
      }

      if (this.intro.length >= 1048) {
        showError && util.notifyError('Intro too long', 'Keep page intro within about 1000 characters');
        return false;
      }

      return true;
    },
    getSaveUrl: function getSaveUrl() {
      if (this.id > 0) return '/api/pages/' + this.id;else return '/api/pages';
    },
    getSaveMethod: function getSaveMethod() {
      if (this.id > 0) return 'put';else return 'post';
    },
    autoSave: function autoSave() {//this.isValid(false) && this.initiateSave()
    },
    initiateSave: function initiateSave() {
      if (this.isValid(true)) {
        this.errors = {};
        this.isSaving = true;
        util.ajax(this.getSaveMethod(), this.getSaveUrl(), {
          id: this.id,
          title: this.title,
          summary: this.intro,
          content: this.contents,
          metakey: this.metakey,
          metadesc: this.metadesc,
          category_id: this.category_id,
          media_id: !!this.media ? this.media.id : null,
          status: this.status,
          editor: this.EDITOR_IDENTITY
        }, this.onPostSuccess, this.on4xxError, this.on5xxError);
      }
    },
    onPostSuccess: function onPostSuccess(successResponse) {
      if (this.isJustCreated()) {
        // assign new Id
        var id = parseInt(successResponse.id);
        this.id = id; // change the address bar URL to en edit page url

        this.$router.replace({
          path: '/app/pages/' + id
        });
      }

      this.contents.map(function (content) {
        content.changed = false;
      });
      this.isSaving = false;
      util.toast({
        icon: 'success',
        titleText: 'Page Contents are Saved.'
      });
    },
    // end of onPostSuccess
    on4xxError: function on4xxError(status, data) {
      this.isSaving = false;
      util.notifyError("Ouch! Couldn't save that...", data.message);

      if (status === 422) {
        this.errors = data.errors;
      }
    },
    on5xxError: function on5xxError(status, data) {
      this.isSaving = false;
      util.notifyError('Failed to save the page to server.', data.message);
      console.log(data);
    },
    isJustCreated: function isJustCreated() {
      return this.id === 0;
    },
    resizeInput: function resizeInput(e) {
      e.target.style.height = 'auto';
      e.target.style.height = e.target.scrollHeight + 'px';
    },
    removeContentBlock: function removeContentBlock(content) {}
  } // end of methods

});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _editorjs_editorjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @editorjs/editorjs */ "./node_modules/@editorjs/editorjs/dist/editor.js");
/* harmony import */ var _editorjs_editorjs__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_editorjs_editorjs__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editorjs_header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @editorjs/header */ "./node_modules/@editorjs/header/dist/bundle.js");
/* harmony import */ var _editorjs_header__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_editorjs_header__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _editorjs_list__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @editorjs/list */ "./node_modules/@editorjs/list/dist/bundle.js");
/* harmony import */ var _editorjs_list__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_editorjs_list__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editorjs_code__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @editorjs/code */ "./node_modules/@editorjs/code/dist/bundle.js");
/* harmony import */ var _editorjs_code__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_editorjs_code__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _editorjs_inline_code__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @editorjs/inline-code */ "./node_modules/@editorjs/inline-code/dist/bundle.js");
/* harmony import */ var _editorjs_inline_code__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_editorjs_inline_code__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _editorjs_marker__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @editorjs/marker */ "./node_modules/@editorjs/marker/dist/bundle.js");
/* harmony import */ var _editorjs_marker__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_editorjs_marker__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @saurav.mitra/editor-table */ "./node_modules/@saurav.mitra/editor-table/dist/bundle.js");
/* harmony import */ var _saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _editorjs_image__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @editorjs/image */ "./node_modules/@editorjs/image/dist/bundle.js");
/* harmony import */ var _editorjs_image__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_editorjs_image__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _editorjs_embed__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @editorjs/embed */ "./node_modules/@editorjs/embed/dist/bundle.js");
/* harmony import */ var _editorjs_embed__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_editorjs_embed__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _PhotoPicker_vue__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./PhotoPicker.vue */ "./resources/js/components/PhotoPicker.vue");
/* harmony import */ var _PageEditorGallery_vue__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./PageEditorGallery.vue */ "./resources/js/components/PageEditorGallery.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//











/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    PhotoPicker: _PhotoPicker_vue__WEBPACK_IMPORTED_MODULE_9__["default"],
    PageEditorGallery: _PageEditorGallery_vue__WEBPACK_IMPORTED_MODULE_10__["default"]
  },
  data: function data() {
    return {
      editor: null,
      id: 0,
      title: null,
      intro: null,
      body: {},
      metakey: null,
      metadesc: null,
      category_id: 1,
      media: null,
      status: 'Draft',
      categories: [],
      tab: 'content',
      isSaving: false,
      errors: {
        title: [],
        summary: [],
        metadesc: [],
        metakey: []
      },
      EDITOR_IDENTITY: 'editorjs',
      showGallery: false,
      timer: null,
      autoSaveFreqSeconds: 60
    };
  },

  /**--------------------------------------------------------------------------
   * Perform these functions when this component is created
   * for the first time only.
   */
  created: function created() {
    this.fetchContentAndLoadEditor();
    this.fetchCategoryListFromServer();
    this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000);
  },
  // end of created
  mounted: function mounted() {
    this.focusInput();
    this.$refs.title.style.height = 'auto';
    this.$refs.intro.style.height = 'auto';
  },
  methods: {
    // simple front-end validations before starting
    // the saving process. Mandatory fields checking.
    isValid: function isValid(showError) {
      if (typeof showError === 'undefined') showError = false;

      if (!this.title) {
        showError && util.notifyError('Page has no title', 'Provide a title to save this page');
        return false;
      }

      if (this.title.length >= 100) {
        showError && util.notifyError('Page title too long!', 'Keep page title within maximum 100 characters.');
        return false;
      }

      if (!this.intro) {
        showError && util.notifyError('Provide an Introduction', 'Write a few lines of intro for this page before saving.');
        return false;
      }

      if (this.intro.length >= 1048) {
        showError && util.notifyError('Intro too long', 'Keep page intro within about 1000 characters');
        return false;
      }

      return true;
    },
    getSaveUrl: function getSaveUrl() {
      if (this.id > 0) return '/api/pages/' + this.id;else return '/api/pages';
    },
    getSaveMethod: function getSaveMethod() {
      if (this.id > 0) return 'put';else return 'post';
    },
    autoSave: function autoSave() {//this.isValid(false) && this.initiateSave()
    },
    initiateSave: function initiateSave() {
      var _this = this;

      if (this.isValid(true)) {
        this.errors = {};
        this.isSaving = true;
        this.editor.save().then(function (bodyJson) {
          util.ajax(_this.getSaveMethod(), _this.getSaveUrl(), {
            id: _this.id,
            title: _this.title,
            summary: _this.intro,
            body_json: JSON.stringify(bodyJson),
            metakey: _this.metakey,
            metadesc: _this.metadesc,
            category_id: _this.category_id,
            media_id: !!_this.media ? _this.media.id : null,
            status: _this.status,
            editor: _this.EDITOR_IDENTITY
          }, _this.postSaveProcessing, _this.handle4xxError, _this.handle5xxError);
        })["catch"](function (error) {
          util.toast({
            icon: 'error',
            title: 'Editor failed. Refresh and try again.'
          });
          _this.isSaving = false;
          console.log('Saving failed: ', error);
        });
      }
    },

    /*--------------------------------------------------------------------------
     * Processes the Id after a successful saving
     */
    postSaveProcessing: function postSaveProcessing(successResponse) {
      if (this.isJustCreated()) {
        // assign new Id
        var id = parseInt(successResponse.id);
        this.id = id; // change the address bar URL to en edit page url

        this.$router.replace({
          path: '/app/pages/' + id
        });
      } // console.table({
      //     method: p.getSaveMethod(),
      //     url: p.getSaveUrl(),
      //     "ID sent": p.id,
      //     "ID returned": id
      // })


      this.isSaving = false;
      util.toast({
        icon: 'success',
        titleText: 'Page Contents are Saved.' // text: 'The page has been saved successfully'

      });
    },
    // end of postSaveProcessing
    handle4xxError: function handle4xxError(status, data) {
      this.isSaving = false;
      util.notifyError("Ouch! Couldn't save that...", data.message);

      if (status === 422) {
        this.errors = data.errors;
      }
    },
    handle5xxError: function handle5xxError(status, data) {
      this.isSaving = false;
      util.notifyError('Failed to save the page to server.', data.message);
      console.log(data);
    },
    isJustCreated: function isJustCreated() {
      return this.id === 0;
    },

    /**--------------------------------------------------------------------------
     * If the article ID is present (e.g. passed as a URL parameter via router),
     * then this method will make an AJAX query in the server to fetch the
     * contents of the article from the database when Vue is created.
     */
    fetchContentAndLoadEditor: function fetchContentAndLoadEditor() {
      if (typeof this.$route.params.id != 'undefined' && parseInt(this.$route.params.id) > 0) {
        // download data from server...
        // console.log('Page Id = ' + this.$route.params.id + ' passed via router param. Downloading contents...')
        var p = this;
        util.ajax('get', '/api/pages/' + this.$route.params.id, {}, function (data) {
          p.id = data.id;
          p.title = data.title;
          p.intro = data.summary;
          p.metakey = data.metakey;
          p.metadesc = data.metadesc;
          p.category_id = data.category_id;
          p.status = data.status;
          p.media = data.media;
          p.body = JSON.parse(data.content[0].body_json);
          p.editor = p.loadEditorTool();
        });
      } else {
        this.editor = this.loadEditorTool();
      }
    },
    // end of fetchContentAndLoadEditor
    fetchCategoryListFromServer: function fetchCategoryListFromServer() {
      var p = this;
      util.ajax('get', '/api/lov/categories', {}, function (data) {
        p.categories = data;
      });
    },
    // end of fetchCategoryListFromServer
    deletePage: function deletePage() {
      var p = this;
      util.confirm('Delete this page?', 'This action can not be reverted', function () {
        util.ajax('delete', '/api/pages/' + p.id, {}, function (response) {
          util.notifySuccess('Deleted', 'The page has been successfully deleted');
          p.$router.push('/app/pages');
        });
      });
    },

    /**--------------------------------------------------------------------------
     * Invokes the Editor and pre-configures the editor with various editor tools
     */
    loadEditorTool: function loadEditorTool() {
      return new _editorjs_editorjs__WEBPACK_IMPORTED_MODULE_0___default.a({
        holder: 'tensor-editor',
        data: this.body,
        tools: {
          // allows you to insert a header block
          header: {
            "class": _editorjs_header__WEBPACK_IMPORTED_MODULE_1___default.a,
            inlineToolbar: true,
            config: {
              placeholder: 'Enter a sub-heading...',
              levels: [2, 3, 4]
            }
          },
          // allows you to highlight inline texts
          marker: _editorjs_marker__WEBPACK_IMPORTED_MODULE_5___default.a,
          // imageBrowser: ImageBrowser,
          // allows you to add a list
          list: {
            "class": _editorjs_list__WEBPACK_IMPORTED_MODULE_2___default.a,
            inlineToolbar: true
          },
          // allows you to embed code
          code: _editorjs_code__WEBPACK_IMPORTED_MODULE_3___default.a,
          inlineCode: _editorjs_inline_code__WEBPACK_IMPORTED_MODULE_4___default.a,
          // allows you to add table in the text
          table: {
            "class": _saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_6___default.a,
            config: {
              rows: 2,
              cols: 2
            }
          },
          // allows uploading image via the editor
          image: {
            "class": _editorjs_image__WEBPACK_IMPORTED_MODULE_7___default.a,
            config: {
              endpoints: {
                byFile: '/api/media',
                // Backend file uploader endpoint
                byUrl: '/api/media/fetchUrl' // Endpoint that provides uploading by Url

              },
              additionalRequestHeaders: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
              }
            }
          },
          embed: {
            "class": _editorjs_embed__WEBPACK_IMPORTED_MODULE_8___default.a,
            inlineToolbar: true,
            config: {
              services: {
                youtube: true,
                vimeo: true,
                codepen: true
              }
            }
          }
        } // end of tools

      }); // end of return
    },
    // end of loadEditorTool
    focusInput: function focusInput() {
      this.$refs.title.focus();
    },
    resizeInput: function resizeInput(e) {
      e.target.style.height = 'auto';
      e.target.style.height = e.target.scrollHeight + 'px';
    },
    imageSelected: function imageSelected(image) {//console.log(image)
    }
  },
  // end of methods
  beforeDestroy: function beforeDestroy() {
    window.clearInterval(this.timer);
  },
  computed: {
    url: function url() {
      return window.location.hostname + '/pages/' + this.id + '-' + (!!this.title ? this.title.replace(/\W+/g, '-').toLowerCase() : '');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContentBlocks.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorRaw_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorRaw.vue */ "./resources/js/components/PageEditorRaw.vue");
/* harmony import */ var _PageEditorJsPlus_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorJsPlus.vue */ "./resources/js/components/PageEditorJsPlus.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    contents: {
      type: Array
    }
  },
  methods: {
    removeBlock: function removeBlock(index) {
      console.log('acknowledged remove request for index', index); // for (let i = 0; i < this.instances.length; i++) {
      //     let instance = this.instances[i]
      //     console.log('checking ', instance.content.display_order)
      //     if (instance.content.display_order === content.display_order) {
      //         console.log('found the instance in register')
      //         instance.instance.destroy()
      //         break
      //     }
      // }

      for (var i = 0; i < this.contents.length; i++) {
        var content = this.contents[i];

        if (content.id === index) {
          this.contents.splice(i, 1);
          break;
        }
      } // this.contents[index]['flag'] = true
      // this.$emit('delete', index)
      // this.contents.splice(index, 1)

    }
  },
  data: function data() {
    return {
      showBlocks: false,
      blockTypes: [{
        type: 'editorjs',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        header: 'Editor',
        text: 'A simple and beautiful WYSIWYG Editor for regular use'
      }, {
        type: 'html',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>',
        header: 'HTML',
        text: 'Create your custom markup using raw HTML code.'
      }, {
        type: 'markdown',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
        header: 'Markdown',
        text: 'Create rich page in markdown with plain-text formatting'
      }, {
        type: 'gallery',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>',
        header: 'Image Gallery',
        text: 'Embed an image gallery with selected set of images'
      }, {
        type: 'tweet',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>',
        header: 'Embed a Tweet',
        text: 'Embed a specific tweet from Twitter directly in the page'
      }, {
        type: 'columns',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path></svg>',
        header: 'Multi-Column',
        text: 'Show contents side by side in multi-column layout'
      }, {
        type: 'note',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        header: 'Note Card',
        text: 'A simple but beautiful WYSIWYG Editor'
      }]
    };
  },
  components: {
    PageEditorRaw: _PageEditorRaw_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    PageEditorJsPlus: _PageEditorJsPlus_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorGallery.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorGallery.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _akashmitra_vue_image_browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @akashmitra/vue-image-browser */ "./node_modules/@akashmitra/vue-image-browser/dist/vue-image-browser.esm.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    VueImageBrowser: _akashmitra_vue_image_browser__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: {
    showGallery: {
      type: Boolean
    }
  },
  data: function data() {
    return {
      photos: [],
      selectedPhoto: null,
      headers: {
        'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
      },
      showCopyBtn: false
    };
  },
  created: function created() {
    this.getFromServer();
  },
  methods: {
    onSelect: function onSelect(image) {
      this.showCopyBtn = true;
      this.selectedPhoto = image;
    },
    copy: function copy() {
      var p = this;
      var fqdn = window.location.origin + this.selectedPhoto.url;

      if (navigator.clipboard) {
        navigator.clipboard.writeText(fqdn).then(function () {
          p.$emit('selected', p.selectedPhoto);
          p.$emit('close');
        });
      }
    },
    close: function close() {
      this.$emit('close');
    },
    onSearch: function onSearch(query) {
      this.getFromServer(query);
    },
    onSave: function onSave(image) {
      this.photos.unshift(image.file);
    },
    getFromServer: function getFromServer(query) {
      var p = this;
      var url = '/api/media' + (typeof query != 'undefined' && query != null ? '?query=' + encodeURIComponent(query) : '');
      util.ajax('GET', url, {}, function (response) {
        p.photos = response.data;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorJsPlus.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editorjs_editorjs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @editorjs/editorjs */ "./node_modules/@editorjs/editorjs/dist/editor.js");
/* harmony import */ var _editorjs_editorjs__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_editorjs_editorjs__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _editorjs_header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @editorjs/header */ "./node_modules/@editorjs/header/dist/bundle.js");
/* harmony import */ var _editorjs_header__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_editorjs_header__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editorjs_list__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @editorjs/list */ "./node_modules/@editorjs/list/dist/bundle.js");
/* harmony import */ var _editorjs_list__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_editorjs_list__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _editorjs_code__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @editorjs/code */ "./node_modules/@editorjs/code/dist/bundle.js");
/* harmony import */ var _editorjs_code__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_editorjs_code__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _editorjs_inline_code__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @editorjs/inline-code */ "./node_modules/@editorjs/inline-code/dist/bundle.js");
/* harmony import */ var _editorjs_inline_code__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_editorjs_inline_code__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _editorjs_marker__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @editorjs/marker */ "./node_modules/@editorjs/marker/dist/bundle.js");
/* harmony import */ var _editorjs_marker__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_editorjs_marker__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @saurav.mitra/editor-table */ "./node_modules/@saurav.mitra/editor-table/dist/bundle.js");
/* harmony import */ var _saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _editorjs_image__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @editorjs/image */ "./node_modules/@editorjs/image/dist/bundle.js");
/* harmony import */ var _editorjs_image__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_editorjs_image__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _editorjs_embed__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @editorjs/embed */ "./node_modules/@editorjs/embed/dist/bundle.js");
/* harmony import */ var _editorjs_embed__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_editorjs_embed__WEBPACK_IMPORTED_MODULE_9__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//









/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    // holderId: {
    //     type: String,
    //     default: () => Math.random().toString().substr(2),
    //     required: false,
    // },
    content: {
      type: Object,
      "default": function _default() {
        return {
          blocks: []
        };
      },
      required: false
    }
  },
  data: function data() {
    return {
      editor: null,
      holderId: Math.random().toString().substr(2),
      tools: {
        // allows you to insert a header block
        header: {
          "class": _editorjs_header__WEBPACK_IMPORTED_MODULE_2___default.a,
          inlineToolbar: true,
          config: {
            placeholder: 'Enter a sub-heading...',
            levels: [2, 3, 4]
          }
        },
        // allows you to highlight inline texts
        marker: _editorjs_marker__WEBPACK_IMPORTED_MODULE_6___default.a,
        // imageBrowser: ImageBrowser,
        // allows you to add a list
        list: {
          "class": _editorjs_list__WEBPACK_IMPORTED_MODULE_3___default.a,
          inlineToolbar: true
        },
        // allows you to embed code
        code: _editorjs_code__WEBPACK_IMPORTED_MODULE_4___default.a,
        inlineCode: _editorjs_inline_code__WEBPACK_IMPORTED_MODULE_5___default.a,
        // allows you to add table in the text
        table: {
          "class": _saurav_mitra_editor_table__WEBPACK_IMPORTED_MODULE_7___default.a,
          config: {
            rows: 2,
            cols: 2
          }
        },
        // allows uploading image via the editor
        image: {
          "class": _editorjs_image__WEBPACK_IMPORTED_MODULE_8___default.a,
          config: {
            endpoints: {
              byFile: '/api/media',
              // Backend file uploader endpoint
              byUrl: '/api/media/fetchUrl' // Endpoint that provides uploading by Url

            },
            additionalRequestHeaders: {
              'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
          }
        },
        embed: {
          "class": _editorjs_embed__WEBPACK_IMPORTED_MODULE_9___default.a,
          inlineToolbar: true,
          config: {
            services: {
              youtube: true,
              vimeo: true,
              codepen: true
            }
          }
        }
      },
      // end of tools
      i18n: null
    };
  },
  mounted: function mounted() {
    this.initEditor();
  },
  beforeDestroy: function beforeDestroy() {
    // if (this.editor) {
    //     this.editor.destroy()
    // }
    console.log('dying', this.holderId, this.content.id);
  },
  beforeCreate: function beforeCreate() {
    console.log('Creating new EditorJS');
  },
  methods: {
    initEditor: function initEditor() {
      var _this = this;

      console.log('initialising editor for content ', this.holderId, this.content.id); // if (!this.editor) {

      this.editor = new _editorjs_editorjs__WEBPACK_IMPORTED_MODULE_1___default.a({
        holder: this.holderId,
        autofocus: false,
        placeholder: 'write something',
        minHeight: 20,
        data: this.content.body_json,
        tools: this.tools,
        // onReady: () => {
        //     this.$emit('ready')
        // },
        onChange: function () {
          var _onChange = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
            var contents;
            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
              while (1) {
                switch (_context.prev = _context.next) {
                  case 0:
                    _context.next = 2;
                    return _this.editor.save();

                  case 2:
                    contents = _context.sent;

                    // console.log(contents)
                    _this.$emit('change', contents);

                  case 4:
                  case "end":
                    return _context.stop();
                }
              }
            }, _callee);
          }));

          function onChange() {
            return _onChange.apply(this, arguments);
          }

          return onChange;
        }()
      }); //this.$emit('init', { content: this.content, instance: this.editor })
      // }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorMenu.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorMenu.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    value: {
      type: String
    },
    isSaving: {
      type: Boolean,
      "default": false
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorRaw.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorRaw.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['content']
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorSeo.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      id: 0,
      title: null,
      intro: null,
      contents: [],
      metakey: null,
      metadesc: null,
      category_id: 1,
      media: null,
      status: 'Draft',
      categories: [],
      tab: 'content',
      isSaving: false,
      errors: {
        title: [],
        summary: [],
        metadesc: [],
        metakey: []
      },
      EDITOR_IDENTITY: 'editorjs',
      showGallery: false,
      timer: null,
      autoSaveFreqSeconds: 60
    };
  },

  /**--------------------------------------------------------------------------
   * Perform these functions when this component is created
   * for the first time only.
   */
  created: function created() {
    //this.fetchContentAndLoadEditor()
    //this.fetchCategoryListFromServer()
    this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000);
  },
  // end of created
  methods: {},
  // end of methods
  beforeDestroy: function beforeDestroy() {
    window.clearInterval(this.timer);
  },
  computed: {
    url: function url() {
      return window.location.hostname + '/pages/' + this.id + '-' + (!!this.title ? this.title.replace(/\W+/g, '-').toLowerCase() : '');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSetting.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorSetting.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PhotoPicker_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PhotoPicker.vue */ "./resources/js/components/PhotoPicker.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    PhotoPicker: _PhotoPicker_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      id: 0,
      title: null,
      intro: null,
      contents: [],
      metakey: null,
      metadesc: null,
      category_id: 1,
      media: null,
      status: 'Draft',
      categories: [],
      tab: 'content',
      isSaving: false,
      errors: {
        title: [],
        summary: [],
        metadesc: [],
        metakey: []
      },
      EDITOR_IDENTITY: 'editorjs',
      showGallery: false,
      timer: null,
      autoSaveFreqSeconds: 60
    };
  },

  /**--------------------------------------------------------------------------
   * Perform these functions when this component is created
   * for the first time only.
   */
  created: function created() {
    //this.fetchContentAndLoadEditor()
    //this.fetchCategoryListFromServer()
    this.timer = window.setInterval(this.autoSave, this.autoSaveFreqSeconds * 1000);
  },
  // end of created
  methods: {},
  // end of methods
  beforeDestroy: function beforeDestroy() {
    window.clearInterval(this.timer);
  },
  computed: {
    url: function url() {
      return window.location.hostname + '/pages/' + this.id + '-' + (!!this.title ? this.title.replace(/\W+/g, '-').toLowerCase() : '');
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n/**\n     * Background color for the icons of \"content\", \"meta\", \"seetings\"\n     * during the mobile responsive mode\n     */\n.bg-icon-primary {\n    fill: #a5b3bb;\n}\ndiv.ce-paragraph {\n    /*\n            top and bottom padding must be equal to\n            ensure correct positioning of \"+\"\n            sign on left margin\n        */\n    padding-top: 0.75rem;\n    padding-bottom: 0.75rem;\n    padding-left: 0.5rem;\n    padding-right: 0.5rem;\n\n    font-size: 1rem;\n    line-height: 1.625;\n}\nh2.ce-header,\nh3.ce-header,\nh4.ce-header {\n    padding-top: 1rem;\n    padding-bottom: 0.25rem;\n    margin-bottom: 0;\n    margin-top: 0;\n    font-family: Georgia, Cambria, 'Times New Roman', Times, serif;\n    -webkit-font-smoothing: antialiased;\n    -moz-osx-font-smoothing: grayscale;\n}\nh2.ce-header {\n    font-size: 1.875rem;\n    line-height: 1.25;\n    font-weight: 600;\n    padding-bottom: 1rem;\n    padding-top: 1rem;\n}\nh3.ce-header {\n    font-size: 1.875rem;\n    line-height: 1.35;\n}\nh4.ce-header {\n    font-size: 1.2rem;\n    font-weight: 700;\n    line-height: 1.375;\n    letter-spacing: 0.025em;\n    padding-bottom: 0.25rem;\n}\nli.cdx-list__item {\n    padding: 0.3rem 0 0.3rem 0.5rem;\n    line-height: 1.625;\n}\n\n/**\n     * IMAGE BORDER Styles.\n     *\n     * Disable the original 1px border that comes with editorjs.\n     * Create a new 1rem border with shadow.\n     */\n.image-tool--withBorder div.image-tool__image {\n    border-style: none;\n}\n.image-tool--withBorder img {\n    /* equivalent to border p-4 shadow; */\n\n    border: 1px solid #ccc;\n    padding: 1rem;\n    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);\n}\n\n/**\n     * IMAGE STRETCHED Styles.\n     *\n     * The image should stretch 100% of the container.\n     */\n.ce-block--stretched,\n.ce-block--stretched img {\n    width: 100%;\n}\n\n/* On screens that are 768px or more, set the padding */\n@media screen and (min-width: 768px) {\n.ce-block--stretched {\n        padding-right: 6rem;\n        padding-left: 6rem;\n}\n}\n\n/**\n     * IMAGE BACKGROUND\n     *\n     * Following css will reprogram the editorjs background\n     * to work more like a image centering tool.\n     */\n.image-tool--withBackground div.image-tool__image {\n    /* bg-white p-0; */\n    background-color: #fff;\n    padding: 0;\n}\n.image-tool--withBackground img.image-tool__image-picture {\n    max-width: 100%;\n}\n\n/**\n     * IMAGE CAPTION BOX\n     *\n     * Design for the caption box below image.\n     */\n.image-tool__caption {\n    /* equivalent to bg-gray-100 rounded p-2 shadow-inner border */\n    background-color: #f7fafc;\n    border-radius: 0.25rem;\n    padding: 0.5rem;\n    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);\n    border-width: 1px;\n}\n\n/* Right Side Settings Menu\n     *\n     * Settings menu width.\n     */\n.ce-settings {\n    min-width: 120px;\n}\n\n/**\n     * CODE BOX\n     * Make sure that the code box height is not too high by default\n     * Set the height to 100px.\n     */\n.ce-code__textarea {\n    height: 100px;\n    min-height: 60px;\n}\n\n/*\n     * Google SERP styles for Search preview\n     */\n.google-header {\n    font-family: arial, sans-serif;\n    font-size: 20px;\n    line-height: 1.3;\n    cursor: pointer;\n    color: #1a0dab;\n}\n.google-url {\n    font-family: arial, sans-serif;\n    font-size: 16px;\n    line-height: 1.5;\n    padding-top: 1px;\n    color: #006621;\n}\n.google-desc {\n    line-height: 1.57;\n    word-wrap: break-word;\n    color: #545454;\n    font-family: arial, sans-serif;\n    font-size: 14px;\n}\n\n/* for autosizing the textareas */\n.autoheight {\n    resize: none;\n    overflow: hidden;\n    min-height: 2em;\n    max-height: 10em;\n}\n.bg-pattern {\n    background-color: #cbd5e0;\n    background-image: url(\"data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a0aec0' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E\");\n}\n", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "\n.hover-left-border[data-v-27e7a1c8]:hover {\n    border-left: 1px solid lightblue;\n}\n.hover-left-border[data-v-27e7a1c8] {\n    box-sizing: border-box;\n}\n", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n/**\n     * Background color for the icons of \"content\", \"meta\", \"seetings\"\n     * during the mobile responsive mode\n     */\n.bg-icon-primary {\n    fill: #a5b3bb;\n}\ndiv.ce-paragraph {\n    /*\n            top and bottom padding must be equal to\n            ensure correct positioning of \"+\"\n            sign on left margin\n        */\n    padding-top: 0.75rem;\n    padding-bottom: 0.75rem;\n    padding-left: 0.5rem;\n    padding-right: 0.5rem;\n\n    font-size: 1rem;\n    line-height: 1.625;\n}\nh2.ce-header,\nh3.ce-header,\nh4.ce-header {\n    padding-top: 1rem;\n    padding-bottom: 0.25rem;\n    margin-bottom: 0;\n    margin-top: 0;\n    font-family: Georgia, Cambria, 'Times New Roman', Times, serif;\n    -webkit-font-smoothing: antialiased;\n    -moz-osx-font-smoothing: grayscale;\n}\nh2.ce-header {\n    font-size: 1.875rem;\n    line-height: 1.25;\n    font-weight: 600;\n    padding-bottom: 1rem;\n    padding-top: 1rem;\n}\nh3.ce-header {\n    font-size: 1.875rem;\n    line-height: 1.35;\n}\nh4.ce-header {\n    font-size: 1.2rem;\n    font-weight: 700;\n    line-height: 1.375;\n    letter-spacing: 0.025em;\n    padding-bottom: 0.25rem;\n}\nli.cdx-list__item {\n    padding: 0.3rem 0 0.3rem 0.5rem;\n    line-height: 1.625;\n}\n\n/**\n     * IMAGE BORDER Styles.\n     *\n     * Disable the original 1px border that comes with editorjs.\n     * Create a new 1rem border with shadow.\n     */\n.image-tool--withBorder div.image-tool__image {\n    border-style: none;\n}\n.image-tool--withBorder img {\n    /* equivalent to border p-4 shadow; */\n\n    border: 1px solid #ccc;\n    padding: 1rem;\n    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);\n}\n\n/**\n     * IMAGE STRETCHED Styles.\n     *\n     * The image should stretch 100% of the container.\n     */\n.ce-block--stretched,\n.ce-block--stretched img {\n    width: 100%;\n}\n\n/* On screens that are 768px or more, set the padding */\n@media screen and (min-width: 768px) {\n.ce-block--stretched {\n        padding-right: 6rem;\n        padding-left: 6rem;\n}\n}\n\n/**\n     * IMAGE BACKGROUND\n     *\n     * Following css will reprogram the editorjs background\n     * to work more like a image centering tool.\n     */\n.image-tool--withBackground div.image-tool__image {\n    /* bg-white p-0; */\n    background-color: #fff;\n    padding: 0;\n}\n.image-tool--withBackground img.image-tool__image-picture {\n    max-width: 100%;\n}\n\n/**\n     * IMAGE CAPTION BOX\n     *\n     * Design for the caption box below image.\n     */\n.image-tool__caption {\n    /* equivalent to bg-gray-100 rounded p-2 shadow-inner border */\n    background-color: #f7fafc;\n    border-radius: 0.25rem;\n    padding: 0.5rem;\n    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);\n    border-width: 1px;\n}\n\n/* Right Side Settings Menu\n     *\n     * Settings menu width.\n     */\n.ce-settings {\n    min-width: 120px;\n}\n\n/**\n     * CODE BOX\n     * Make sure that the code box height is not too high by default\n     * Set the height to 100px.\n     */\n.ce-code__textarea {\n    height: 100px;\n    min-height: 60px;\n}\n\n/*\n     * Google SERP styles for Search preview\n     */\n.google-header {\n    font-family: arial, sans-serif;\n    font-size: 20px;\n    line-height: 1.3;\n    cursor: pointer;\n    color: #1a0dab;\n}\n.google-url {\n    font-family: arial, sans-serif;\n    font-size: 16px;\n    line-height: 1.5;\n    padding-top: 1px;\n    color: #006621;\n}\n.google-desc {\n    line-height: 1.57;\n    word-wrap: break-word;\n    color: #545454;\n    font-family: arial, sans-serif;\n    font-size: 14px;\n}\n\n/* for autosizing the textareas */\n.autoheight {\n    resize: none;\n    overflow: hidden;\n    min-height: 2em;\n    max-height: 10em;\n}\n.bg-pattern {\n    background-color: #cbd5e0;\n    background-image: url(\"data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a0aec0' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E\");\n}\n", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n/**\n     * Background color for the icons of \"content\", \"meta\", \"seetings\"\n     * during the mobile responsive mode\n     */\n.bg-icon-primary {\n    fill: #a5b3bb;\n}\ndiv.ce-paragraph {\n    /*\n            top and bottom padding must be equal to\n            ensure correct positioning of \"+\"\n            sign on left margin\n        */\n    padding-top: 0.75rem;\n    padding-bottom: 0.75rem;\n    padding-left: 0.5rem;\n    padding-right: 0.5rem;\n\n    font-size: 1rem;\n    line-height: 1.625;\n}\nh2.ce-header,\nh3.ce-header,\nh4.ce-header {\n    padding-top: 1rem;\n    padding-bottom: 0.25rem;\n    margin-bottom: 0;\n    margin-top: 0;\n    font-family: Georgia, Cambria, 'Times New Roman', Times, serif;\n    -webkit-font-smoothing: antialiased;\n    -moz-osx-font-smoothing: grayscale;\n}\nh2.ce-header {\n    font-size: 1.875rem;\n    line-height: 1.25;\n    font-weight: 600;\n    padding-bottom: 1rem;\n    padding-top: 1rem;\n}\nh3.ce-header {\n    font-size: 1.875rem;\n    line-height: 1.35;\n}\nh4.ce-header {\n    font-size: 1.2rem;\n    font-weight: 700;\n    line-height: 1.375;\n    letter-spacing: 0.025em;\n    padding-bottom: 0.25rem;\n}\nli.cdx-list__item {\n    padding: 0.3rem 0 0.3rem 0.5rem;\n    line-height: 1.625;\n}\n\n/**\n     * IMAGE BORDER Styles.\n     *\n     * Disable the original 1px border that comes with editorjs.\n     * Create a new 1rem border with shadow.\n     */\n.image-tool--withBorder div.image-tool__image {\n    border-style: none;\n}\n.image-tool--withBorder img {\n    /* equivalent to border p-4 shadow; */\n\n    border: 1px solid #ccc;\n    padding: 1rem;\n    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);\n}\n\n/**\n     * IMAGE STRETCHED Styles.\n     *\n     * The image should stretch 100% of the container.\n     */\n.ce-block--stretched,\n.ce-block--stretched img {\n    width: 100%;\n}\n\n/* On screens that are 768px or more, set the padding */\n@media screen and (min-width: 768px) {\n.ce-block--stretched {\n        padding-right: 6rem;\n        padding-left: 6rem;\n}\n}\n\n/**\n     * IMAGE BACKGROUND\n     *\n     * Following css will reprogram the editorjs background\n     * to work more like a image centering tool.\n     */\n.image-tool--withBackground div.image-tool__image {\n    /* bg-white p-0; */\n    background-color: #fff;\n    padding: 0;\n}\n.image-tool--withBackground img.image-tool__image-picture {\n    max-width: 100%;\n}\n\n/**\n     * IMAGE CAPTION BOX\n     *\n     * Design for the caption box below image.\n     */\n.image-tool__caption {\n    /* equivalent to bg-gray-100 rounded p-2 shadow-inner border */\n    background-color: #f7fafc;\n    border-radius: 0.25rem;\n    padding: 0.5rem;\n    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);\n    border-width: 1px;\n}\n\n/* Right Side Settings Menu\n     *\n     * Settings menu width.\n     */\n.ce-settings {\n    min-width: 120px;\n}\n\n/**\n     * CODE BOX\n     * Make sure that the code box height is not too high by default\n     * Set the height to 100px.\n     */\n.ce-code__textarea {\n    height: 100px;\n    min-height: 60px;\n}\n\n/*\n     * Google SERP styles for Search preview\n     */\n.google-header {\n    font-family: arial, sans-serif;\n    font-size: 20px;\n    line-height: 1.3;\n    cursor: pointer;\n    color: #1a0dab;\n}\n.google-url {\n    font-family: arial, sans-serif;\n    font-size: 16px;\n    line-height: 1.5;\n    padding-top: 1px;\n    color: #006621;\n}\n.google-desc {\n    line-height: 1.57;\n    word-wrap: break-word;\n    color: #545454;\n    font-family: arial, sans-serif;\n    font-size: 14px;\n}\n\n/* for autosizing the textareas */\n.autoheight {\n    resize: none;\n    overflow: hidden;\n    min-height: 2em;\n    max-height: 10em;\n}\n.bg-pattern {\n    background-color: #cbd5e0;\n    background-image: url(\"data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a0aec0' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E\");\n}\n", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorJsPlus.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorSeo.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=template&id=a5de30f2&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=template&id=a5de30f2& ***!
  \*************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "w-full bg-gray-200" },
    [
      _c("PageEditorMenu", {
        on: { save: _vm.initiateSave },
        model: {
          value: _vm.tab,
          callback: function($$v) {
            _vm.tab = $$v
          },
          expression: "tab"
        }
      }),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.tab === "content",
              expression: "tab === 'content'"
            }
          ],
          staticClass: "w-full px-6",
          attrs: { id: "page-contents" }
        },
        [
          _c(
            "div",
            { staticClass: "py-10 w-full max-w-5xl bg-white mx-auto border-b" },
            [
              _c(
                "div",
                { staticClass: "w-full mx-auto max-w-2xl" },
                [
                  _c(
                    "label",
                    {
                      staticClass:
                        "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
                    },
                    [
                      _vm._v(
                        "\n                    Title\n                    "
                      ),
                      !!_vm.title
                        ? _c(
                            "span",
                            {
                              staticClass:
                                "bg-gray-100 rounded-lg py-1 px-2 ml-4",
                              class:
                                _vm.title.length > 100
                                  ? "text-red-400"
                                  : "text-gray-600"
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(_vm.title.length)
                              )
                            ]
                          )
                        : _vm._e()
                    ]
                  ),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.title,
                        expression: "title"
                      }
                    ],
                    ref: "title",
                    staticClass:
                      "autoheight h-8 px-6 bg-transparent border-b-2 border-gray-400 outline-none text-blue-800 text-3xl tracking-wide w-full placeholder-gray-700",
                    attrs: {
                      name: "title",
                      placeholder: "Title of your story"
                    },
                    domProps: { value: _vm.title },
                    on: {
                      input: [
                        function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.title = $event.target.value
                        },
                        function($event) {
                          return _vm.resizeInput($event)
                        }
                      ]
                    }
                  }),
                  _vm._v(" "),
                  _c("t-error-message", {
                    attrs: { errors: _vm.errors, field: "title" }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "mt-12 mx-auto max-w-2xl" },
                [
                  _c(
                    "label",
                    {
                      staticClass:
                        "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
                    },
                    [
                      _vm._v(
                        "\n                    Intro\n                    "
                      ),
                      !!_vm.intro
                        ? _c(
                            "span",
                            {
                              staticClass:
                                "bg-gray-100 rounded-lg py-1 px-2 ml-4",
                              class:
                                _vm.intro.length > 1048
                                  ? "text-red-400"
                                  : "text-gray-600"
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(_vm.intro.length) +
                                  "\n                    "
                              )
                            ]
                          )
                        : _vm._e()
                    ]
                  ),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.intro,
                        expression: "intro"
                      }
                    ],
                    ref: "intro",
                    staticClass:
                      "autoheight h-auto px-6 bg-transparent outline-none text-gray-700 text-lg tracking-wide w-full placeholder-gray-700",
                    attrs: {
                      name: "intro",
                      placeholder:
                        "Provide a 3/4 lines of introduction to your story..."
                    },
                    domProps: { value: _vm.intro },
                    on: {
                      input: [
                        function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.intro = $event.target.value
                        },
                        function($event) {
                          return _vm.resizeInput($event)
                        }
                      ],
                      focus: function($event) {
                        return _vm.resizeInput($event)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("t-error-message", {
                    attrs: { errors: _vm.errors, field: "summary" }
                  })
                ],
                1
              )
            ]
          ),
          _vm._v(" "),
          _c("PageEditorContentBlocks", {
            attrs: { contents: _vm.contents },
            on: { select: _vm.addContentBlock, delete: _vm.removeContentBlock }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.tab === "seo",
            expression: "tab === 'seo'"
          }
        ],
        staticClass: "w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20",
        attrs: { id: "page-seo" }
      }),
      _vm._v(" "),
      _c("div", {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.tab === "setting",
            expression: "tab === 'setting'"
          }
        ],
        staticClass: "w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20",
        attrs: { id: "page-setting" }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=template&id=ab7a4abc&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContent.vue?vue&type=template&id=ab7a4abc& ***!
  \********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "pt-10 w-full p-6 pb-24" }, [
      _c(
        "div",
        { staticClass: "mx-auto max-w-4xl" },
        [
          _c(
            "label",
            {
              staticClass:
                "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
            },
            [
              _vm._v("\n                Title\n                "),
              !!_vm.title
                ? _c(
                    "span",
                    {
                      staticClass: "bg-gray-100 rounded-lg py-1 px-2 ml-4",
                      class:
                        _vm.title.length > 100
                          ? "text-red-400"
                          : "text-gray-600"
                    },
                    [
                      _vm._v(
                        "\n                    " + _vm._s(_vm.title.length)
                      )
                    ]
                  )
                : _vm._e()
            ]
          ),
          _vm._v(" "),
          _c("textarea", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.title,
                expression: "title"
              }
            ],
            ref: "title",
            staticClass:
              "autoheight h-8 px-6 bg-transparent border-b-2 border-gray-400 outline-none text-blue-800 text-3xl tracking-wide w-full placeholder-gray-700",
            attrs: { name: "title", placeholder: "Title of your story" },
            domProps: { value: _vm.title },
            on: {
              input: [
                function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.title = $event.target.value
                },
                function($event) {
                  return _vm.resizeInput($event)
                }
              ]
            }
          }),
          _vm._v(" "),
          _c("t-error-message", {
            attrs: { errors: _vm.errors, field: "title" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "mt-12 mx-auto max-w-4xl" },
        [
          _c(
            "label",
            {
              staticClass:
                "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
            },
            [
              _vm._v("\n                Intro\n                "),
              !!_vm.intro
                ? _c(
                    "span",
                    {
                      staticClass: "bg-gray-100 rounded-lg py-1 px-2 ml-4",
                      class:
                        _vm.intro.length > 1048
                          ? "text-red-400"
                          : "text-gray-600"
                    },
                    [
                      _vm._v(
                        "\n                    " + _vm._s(_vm.intro.length)
                      )
                    ]
                  )
                : _vm._e()
            ]
          ),
          _vm._v(" "),
          _c("textarea", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.intro,
                expression: "intro"
              }
            ],
            ref: "intro",
            staticClass:
              "autoheight h-auto px-6 bg-transparent outline-none text-gray-700 text-lg tracking-wide w-full placeholder-gray-700",
            attrs: {
              name: "intro",
              placeholder:
                "Provide a 3/4 lines of introduction to your story..."
            },
            domProps: { value: _vm.intro },
            on: {
              input: [
                function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.intro = $event.target.value
                },
                function($event) {
                  return _vm.resizeInput($event)
                }
              ],
              focus: function($event) {
                return _vm.resizeInput($event)
              }
            }
          }),
          _vm._v(" "),
          _c("t-error-message", {
            attrs: { errors: _vm.errors, field: "summary" }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _vm._m(0)
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "w-full p-2 bg-pattern pb-20" }, [
      _c(
        "div",
        {
          staticClass:
            "max-w-4xl mx-auto bg-white -mt-16 shadow-xl px-6 pt-12 border-t-2 border-blue-400"
        },
        [
          _c("div", {
            staticClass:
              "mx-auto text-gray-700 pb-4 bg-white -mr-2 wt-typography",
            attrs: { id: "tensor-editor" }
          })
        ]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm._l(_vm.contents, function(content, index) {
        return _c(
          "div",
          { key: content.display_order, staticClass: "w-full" },
          [
            _c(
              "div",
              { staticClass: "max-w-5xl bg-white mx-auto border-b relative" },
              [
                _c(
                  "div",
                  {
                    staticClass:
                      "absolute top-0 left-0 shadow text-gray-600 text-xs rounded-lg rounded-t-none px-4 py-1 ml-2",
                    on: {
                      click: function($event) {
                        return _vm.$emit("delete", index)
                      }
                    }
                  },
                  [
                    _vm._v(
                      "\n                " +
                        _vm._s(content.type) +
                        " # " +
                        _vm._s(content.display_order) +
                        "\n            "
                    )
                  ]
                ),
                _vm._v(" "),
                content.type === "raw"
                  ? _c("PageEditorRaw", { attrs: { content: content } })
                  : _vm._e(),
                _vm._v(" "),
                content.type === "editorjs"
                  ? _c("PageEditorJsPlus", {
                      staticClass:
                        "pt-4 border-l border-white hover-left-border",
                      attrs: { content: content },
                      on: {
                        change: function($event) {
                          content.body_json = $event
                        }
                      }
                    })
                  : _vm._e()
              ],
              1
            )
          ]
        )
      }),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "w-full max-w-5xl mx-auto -mt-1c flex justify-end mb-10"
        },
        [
          _c(
            "div",
            {
              staticClass:
                "px-3 py-2 bg-white rounded-lg rounded-t-none inline-block cursor-pointer text-blue-500 font-bold hover:text-blue-600",
              on: {
                click: function($event) {
                  _vm.showBlocks = !_vm.showBlocks
                }
              }
            },
            [_vm._v("\n            + BLOCK\n        ")]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "t-modal",
        {
          attrs: { show: _vm.showBlocks, "show-footer": false },
          on: {
            close: function($event) {
              _vm.showBlocks = false
            }
          },
          scopedSlots: _vm._u([
            {
              key: "header",
              fn: function() {
                return [
                  _c("p", { staticClass: "text-xl text-gray-600 px-6 py-4" }, [
                    _vm._v("Select Content Block")
                  ])
                ]
              },
              proxy: true
            }
          ])
        },
        [
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "p-4 overflow-y-auto border-t flex flex-wrap bg-gray-100",
              staticStyle: { "max-height": "300px" }
            },
            _vm._l(_vm.blockTypes, function(bt) {
              return _c(
                "div",
                { staticClass: "w-full md:w-1/2 xl:w-1/3 p-3" },
                [
                  _c(
                    "div",
                    {
                      staticClass:
                        "bg-white rounded-lg shadow p-4 border cursor-pointer hover:bg-blue-100",
                      on: {
                        click: function($event) {
                          _vm.$emit("add", bt.header)
                          _vm.showBlocks = false
                        }
                      }
                    },
                    [
                      _c("div", {
                        staticClass: "w-full flex justify-center text-gray-500",
                        domProps: { innerHTML: _vm._s(bt.icon) }
                      }),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "w-full flex justify-center font-bold text-blue-600 my-3"
                        },
                        [
                          _vm._v(
                            "\n                        " +
                              _vm._s(bt.header) +
                              "\n                    "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "w-full flex justify-center text-sm text-gray-800 text-center"
                        },
                        [
                          _vm._v(
                            "\n                        " +
                              _vm._s(bt.text) +
                              "\n                    "
                          )
                        ]
                      )
                    ]
                  )
                ]
              )
            }),
            0
          )
        ]
      )
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorGallery.vue?vue&type=template&id=415908fb&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorGallery.vue?vue&type=template&id=415908fb& ***!
  \********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "t-modal",
    {
      attrs: { show: _vm.showGallery },
      on: { close: _vm.close, "go-ahead": _vm.copy },
      scopedSlots: _vm._u([
        {
          key: "header",
          fn: function() {
            return [
              _c("p", { staticClass: "text-xl text-gray-600 px-6 py-4" }, [
                _vm._v("Gallery Images")
              ])
            ]
          },
          proxy: true
        },
        {
          key: "action-btn-content",
          fn: function() {
            return [
              _c(
                "span",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.showCopyBtn,
                      expression: "showCopyBtn"
                    }
                  ],
                  staticClass: "px-6 py-2 text-white bg-green-600 rounded"
                },
                [_vm._v("\n            Copy Image Link\n        ")]
              )
            ]
          },
          proxy: true
        }
      ])
    },
    [
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "px-6 overflow-y-auto border-t",
          staticStyle: { "max-height": "300px" }
        },
        [
          _c("VueImageBrowser", {
            attrs: {
              images: _vm.photos,
              "enable-lazy-load": "",
              "allow-upload": "",
              "save-url": "/api/media",
              "save-request-headers": _vm.headers
            },
            on: {
              selected: _vm.onSelect,
              saved: _vm.onSave,
              searched: _vm.onSearch
            }
          })
        ],
        1
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a& ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { attrs: { id: _vm.holderId } })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorMenu.vue?vue&type=template&id=69b48a06&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorMenu.vue?vue&type=template&id=69b48a06& ***!
  \*****************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "w-full px-6 border-b bg-gray-100" }, [
    _c(
      "div",
      { staticClass: "max-w-5xl mx-auto flex justify-between items-center" },
      [
        _c("div", { staticClass: "flex justify-start items-center" }, [
          _c(
            "div",
            {
              staticClass:
                "px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer",
              class:
                _vm.value === "content"
                  ? "text-blue-600 font-bold border-b-4 border-blue-500"
                  : "",
              attrs: { id: "page-content-tab" },
              on: {
                click: function($event) {
                  return _vm.$emit("input", "content")
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "h-6 w-6 sm:hidden",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    width: "24",
                    height: "24",
                    viewBox: "0 0 24 24",
                    fill: "none",
                    stroke: "currentColor",
                    "stroke-width": "2",
                    "stroke-linecap": "round",
                    "stroke-linejoin": "round"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      d:
                        "M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"
                    }
                  }),
                  _vm._v(" "),
                  _c("path", {
                    attrs: {
                      d:
                        "M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"
                    }
                  })
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                { staticClass: "hidden sm:inline-block tracking-wider" },
                [_vm._v("Content")]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer",
              class:
                _vm.value === "seo"
                  ? "text-blue-600 font-bold border-b-4 border-blue-500"
                  : "",
              attrs: { id: "page-seo-tab" },
              on: {
                click: function($event) {
                  return _vm.$emit("input", "seo")
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "w-6 h-6 sm:hidden",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    width: "24",
                    height: "24",
                    viewBox: "0 0 24 24",
                    fill: "none",
                    stroke: "currentColor",
                    "stroke-width": "2",
                    "stroke-linecap": "round",
                    "stroke-linejoin": "round"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      d:
                        "M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"
                    }
                  })
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                { staticClass: "hidden sm:inline-block tracking-wider" },
                [_vm._v("Seo")]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer",
              class:
                _vm.value === "setting"
                  ? "text-blue-600 font-bold border-b-4 border-blue-500"
                  : "",
              attrs: { id: "page-setting-tab" },
              on: {
                click: function($event) {
                  return _vm.$emit("input", "setting")
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "w-6 h-6 sm:hidden",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    width: "24",
                    height: "24",
                    viewBox: "0 0 24 24",
                    fill: "none",
                    stroke: "currentColor",
                    "stroke-width": "2",
                    "stroke-linecap": "round",
                    "stroke-linejoin": "round"
                  }
                },
                [
                  _c("circle", { attrs: { cx: "12", cy: "12", r: "3" } }),
                  _vm._v(" "),
                  _c("path", {
                    attrs: {
                      d:
                        "M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"
                    }
                  })
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                { staticClass: "hidden sm:inline-block tracking-wider" },
                [_vm._v("Setting")]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "px-6 py-4 text-xs uppercase text-gray-800 cursor-pointer",
              attrs: { id: "page-gallery-tab" },
              on: {
                click: function($event) {
                  return _vm.$emit("gallery")
                }
              }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "w-6 h-6 sm:hidden",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    width: "24",
                    height: "24",
                    viewBox: "0 0 24 24",
                    fill: "none",
                    stroke: "currentColor",
                    "stroke-width": "2",
                    "stroke-linecap": "round",
                    "stroke-linejoin": "round"
                  }
                },
                [
                  _c("rect", {
                    attrs: {
                      x: "3",
                      y: "3",
                      width: "18",
                      height: "18",
                      rx: "2",
                      ry: "2"
                    }
                  }),
                  _vm._v(" "),
                  _c("circle", { attrs: { cx: "8.5", cy: "8.5", r: "1.5" } }),
                  _vm._v(" "),
                  _c("polyline", { attrs: { points: "21 15 16 10 5 21" } })
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                { staticClass: "hidden sm:inline-block tracking-wider" },
                [_vm._v("Gallery")]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c(
          "t-button",
          {
            attrs: { loadingWheel: _vm.isSaving },
            nativeOn: {
              click: function($event) {
                return _vm.$emit("save")
              }
            }
          },
          [_vm._v("\n            Save\n        ")]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorRaw.vue?vue&type=template&id=2ebe9f51&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorRaw.vue?vue&type=template&id=2ebe9f51& ***!
  \****************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "w-full max-w-3xl mx-auto" }, [
    _c("textarea", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.content.body_html,
          expression: "content.body_html"
        }
      ],
      staticClass: "w-full border p-3 rounded-lg",
      domProps: { value: _vm.content.body_html },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.$set(_vm.content, "body_html", $event.target.value)
        }
      }
    })
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=template&id=6a078106&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorSeo.vue?vue&type=template&id=6a078106& ***!
  \****************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" }, [
      _vm._v("Meta Information")
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "bg-white rounded md:flex w-full py-6 px-4 border-t-2 border-blue-400 shadow"
      },
      [
        _c(
          "div",
          { staticClass: "w-full md:w-1/2 px-4" },
          [
            _c("div", { staticClass: "uppercase1 text-gray-800 text-sm" }, [
              _vm._v("Meta Description")
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "h-20 flex items-center text-xs text-gray-600 overflow-y-scroll"
              },
              [
                _vm._v(
                  "\n                Good meta descriptions are short blurbs that describe accurately the content of\n                the page. This gives Google and other search engines a summary of what the page\n                is about.\n            "
                )
              ]
            ),
            _vm._v(" "),
            _c("t-error-message", {
              attrs: { errors: _vm.errors, field: "metadesc" }
            }),
            _vm._v(" "),
            _c("textarea", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.metadesc,
                  expression: "metadesc"
                }
              ],
              staticClass:
                "mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none",
              class: !_vm.metadesc ? "border-red-400" : "",
              attrs: { name: "metadesc" },
              domProps: { value: _vm.metadesc },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.metadesc = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "span",
              {
                staticClass:
                  "mt-3 p-1 text-xs text-blue-700 cursor-pointer hover:text-blue-900",
                on: {
                  click: function($event) {
                    _vm.metadesc = _vm.intro
                  }
                }
              },
              [_vm._v("Copy from Intro text")]
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "w-full mt-4 md:mt-0 md:w-1/2 px-4" },
          [
            _c("div", { staticClass: "uppercase1 text-gray-800 text-sm" }, [
              _vm._v("Meta Keywords")
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "h-20 flex items-center text-xs text-gray-600 overflow-y-scroll"
              },
              [
                _vm._v(
                  "\n                A series of keywords you deem relevant to the page in question. These are used\n                to automatically generate tags for the page. Note that Google doesn’t use meta\n                keywords in its ranking algorithm.\n            "
                )
              ]
            ),
            _vm._v(" "),
            _c("t-error-message", {
              attrs: { errors: _vm.errors, field: "metakey" }
            }),
            _vm._v(" "),
            _c("textarea", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.metakey,
                  expression: "metakey"
                }
              ],
              staticClass:
                "mt-2 w-full bg-gray-100 shadow-inner rounded-lg text-xs text-gray-800 p-4 border focus:outline-none",
              attrs: { name: "metakey" },
              domProps: { value: _vm.metakey },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.metakey = $event.target.value
                }
              }
            })
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" }, [
      _vm._v("Organize")
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow"
      },
      [
        _c("div", { staticClass: "w-full px-4" }, [
          _c("div", { staticClass: "uppercase1 text-gray-800 text-sm" }, [
            _vm._v("Category")
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "py-3 flex items-center text-xs text-gray-600 overflow-y-scroll"
            },
            [
              _vm._v(
                "\n                You may organize your pages under various categories. Category names can be used\n                to create menu items that can link all the pages under the same category.\n            "
              )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "inline-block relative w-64" }, [
            _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.category_id,
                    expression: "category_id"
                  }
                ],
                staticClass:
                  "block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline",
                attrs: { id: "category_id" },
                on: {
                  change: function($event) {
                    var $$selectedVal = Array.prototype.filter
                      .call($event.target.options, function(o) {
                        return o.selected
                      })
                      .map(function(o) {
                        var val = "_value" in o ? o._value : o.value
                        return val
                      })
                    _vm.category_id = $event.target.multiple
                      ? $$selectedVal
                      : $$selectedVal[0]
                  }
                }
              },
              _vm._l(_vm.categories, function(category) {
                return _c(
                  "option",
                  { key: category.key, domProps: { value: category.key } },
                  [
                    _vm._v(
                      "\n                        " +
                        _vm._s(category.value) +
                        "\n                    "
                    )
                  ]
                )
              }),
              0
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
              },
              [
                _c(
                  "svg",
                  {
                    staticClass: "fill-current h-4 w-4",
                    attrs: {
                      xmlns: "http://www.w3.org/2000/svg",
                      viewBox: "0 0 20 20"
                    }
                  },
                  [
                    _c("path", {
                      attrs: {
                        d:
                          "M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                      }
                    })
                  ]
                )
              ]
            )
          ])
        ])
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" }, [
      _vm._v("Search Engine Preview")
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow"
      },
      [
        _c("div", { staticClass: "w-full px-4" }, [
          _c("div", { staticClass: "uppercase1 text-gray-800 text-sm" }, [
            _vm._v("Google Search Preview")
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "py-3 flex items-center text-xs text-gray-600 overflow-y-scroll"
            },
            [
              _vm._v(
                "\n                This is how this page will appear in Google search when using the page meta\n                description. Search engines may use meta description as snippets for your pages\n                or a more relevant section of your page's visible text, if that fits better with\n                a user's query.\n            "
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "mt-2 w-full bg-gray-100 rounded-lg p-4 border" },
            [
              _c("div", { staticClass: "google-header" }, [
                _vm._v(_vm._s(_vm.title))
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "google-url" }, [
                _vm._v(_vm._s(_vm.url))
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "google-desc" }, [
                _vm._v(_vm._s(_vm.metadesc))
              ])
            ]
          )
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSetting.vue?vue&type=template&id=8ba81e0e&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditorSetting.vue?vue&type=template&id=8ba81e0e& ***!
  \********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "w-full" }, [
    _c("div", { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" }, [
      _vm._v("\n        Blog Image\n    ")
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "bg-white rounded w-full border-t-2 border-blue-400 shadow"
      },
      [
        _c("PhotoPicker", {
          attrs: { id: "pageImage", "image-classes": "w-full" },
          model: {
            value: _vm.media,
            callback: function($$v) {
              _vm.media = $$v
            },
            expression: "media"
          }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c("div", { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" }, [
      _vm._v("\n        Publication\n    ")
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "bg-white rounded w-full border-t-2 border-blue-400 shadow"
      },
      [
        _c("t-toggle", {
          staticClass: "pt-6 px-4 mb-4",
          attrs: {
            id: "changeStatus",
            "true-value": "Live",
            "false-value": "Draft",
            "box-class":
              "w-20 shadow-inner bg-gray-100 border rounded-l rounded-r cursor-pointer",
            "true-class":
              "h-6 px-3 bg-blue-400 text-blue-100 rounded shadow-sm",
            "false-class":
              "h-6 px-3 bg-gray-400 text-gray-100 rounded shadow-sm",
            "show-value": true
          },
          model: {
            value: _vm.status,
            callback: function($$v) {
              _vm.status = $$v
            },
            expression: "status"
          }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "px-4 w-full mb-4 text-xs text-gray-700" }, [
          _vm._v(
            "\n            Only Live page will be accessible to site visitors.\n        "
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "flex justify-end p-4 text-right bg-gray-100 border-t"
          },
          [
            _c(
              "span",
              {
                staticClass:
                  "border border-red-500 cursor-pointer text-red-500 hover:text-white px-3 py-2 rounded text-sm hover:bg-red-500",
                attrs: { id: "deletePage" },
                on: { click: _vm.deletePage }
              },
              [_vm._v("\n                Delete this page\n            ")]
            )
          ]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/PageEditor.vue":
/*!************************************************!*\
  !*** ./resources/js/components/PageEditor.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditor_vue_vue_type_template_id_a5de30f2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditor.vue?vue&type=template&id=a5de30f2& */ "./resources/js/components/PageEditor.vue?vue&type=template&id=a5de30f2&");
/* harmony import */ var _PageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditor.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditor_vue_vue_type_template_id_a5de30f2___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditor_vue_vue_type_template_id_a5de30f2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditor.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditor.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/PageEditor.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditor.vue?vue&type=template&id=a5de30f2&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/PageEditor.vue?vue&type=template&id=a5de30f2& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_template_id_a5de30f2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=template&id=a5de30f2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=template&id=a5de30f2&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_template_id_a5de30f2___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_template_id_a5de30f2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorContent.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/PageEditorContent.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorContent_vue_vue_type_template_id_ab7a4abc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorContent.vue?vue&type=template&id=ab7a4abc& */ "./resources/js/components/PageEditorContent.vue?vue&type=template&id=ab7a4abc&");
/* harmony import */ var _PageEditorContent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorContent.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorContent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _PageEditorContent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PageEditorContent.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PageEditorContent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorContent_vue_vue_type_template_id_ab7a4abc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorContent_vue_vue_type_template_id_ab7a4abc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorContent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorContent.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/PageEditorContent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/PageEditorContent.vue?vue&type=template&id=ab7a4abc&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/PageEditorContent.vue?vue&type=template&id=ab7a4abc& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_template_id_ab7a4abc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContent.vue?vue&type=template&id=ab7a4abc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContent.vue?vue&type=template&id=ab7a4abc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_template_id_ab7a4abc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContent_vue_vue_type_template_id_ab7a4abc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorContentBlocks.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/PageEditorContentBlocks.vue ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorContentBlocks_vue_vue_type_template_id_27e7a1c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true& */ "./resources/js/components/PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true&");
/* harmony import */ var _PageEditorContentBlocks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorContentBlocks.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorContentBlocks.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _PageEditorContentBlocks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _PageEditorContentBlocks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _PageEditorContentBlocks_vue_vue_type_style_index_0_id_27e7a1c8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css& */ "./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PageEditorContentBlocks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorContentBlocks_vue_vue_type_template_id_27e7a1c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorContentBlocks_vue_vue_type_template_id_27e7a1c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "27e7a1c8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorContentBlocks.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorContentBlocks.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/PageEditorContentBlocks.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContentBlocks.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css& ***!
  \**********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_style_index_0_id_27e7a1c8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=style&index=0&id=27e7a1c8&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_style_index_0_id_27e7a1c8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_style_index_0_id_27e7a1c8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_style_index_0_id_27e7a1c8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_style_index_0_id_27e7a1c8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_style_index_0_id_27e7a1c8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true& ***!
  \********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_template_id_27e7a1c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorContentBlocks.vue?vue&type=template&id=27e7a1c8&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_template_id_27e7a1c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorContentBlocks_vue_vue_type_template_id_27e7a1c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorGallery.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/PageEditorGallery.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorGallery_vue_vue_type_template_id_415908fb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorGallery.vue?vue&type=template&id=415908fb& */ "./resources/js/components/PageEditorGallery.vue?vue&type=template&id=415908fb&");
/* harmony import */ var _PageEditorGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorGallery.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorGallery.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PageEditorGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorGallery_vue_vue_type_template_id_415908fb___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorGallery_vue_vue_type_template_id_415908fb___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorGallery.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorGallery.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/PageEditorGallery.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorGallery.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorGallery.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorGallery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorGallery.vue?vue&type=template&id=415908fb&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/PageEditorGallery.vue?vue&type=template&id=415908fb& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorGallery_vue_vue_type_template_id_415908fb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorGallery.vue?vue&type=template&id=415908fb& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorGallery.vue?vue&type=template&id=415908fb&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorGallery_vue_vue_type_template_id_415908fb___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorGallery_vue_vue_type_template_id_415908fb___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorJsPlus.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/PageEditorJsPlus.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorJsPlus_vue_vue_type_template_id_7dfe5d6a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a& */ "./resources/js/components/PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a&");
/* harmony import */ var _PageEditorJsPlus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorJsPlus.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorJsPlus.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _PageEditorJsPlus_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PageEditorJsPlus.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PageEditorJsPlus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorJsPlus_vue_vue_type_template_id_7dfe5d6a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorJsPlus_vue_vue_type_template_id_7dfe5d6a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorJsPlus.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorJsPlus.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/PageEditorJsPlus.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorJsPlus.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorJsPlus.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_template_id_7dfe5d6a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorJsPlus.vue?vue&type=template&id=7dfe5d6a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_template_id_7dfe5d6a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorJsPlus_vue_vue_type_template_id_7dfe5d6a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorMenu.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/PageEditorMenu.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorMenu_vue_vue_type_template_id_69b48a06___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorMenu.vue?vue&type=template&id=69b48a06& */ "./resources/js/components/PageEditorMenu.vue?vue&type=template&id=69b48a06&");
/* harmony import */ var _PageEditorMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorMenu.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorMenu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PageEditorMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorMenu_vue_vue_type_template_id_69b48a06___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorMenu_vue_vue_type_template_id_69b48a06___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorMenu.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorMenu.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/PageEditorMenu.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorMenu.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorMenu.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorMenu_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorMenu.vue?vue&type=template&id=69b48a06&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/PageEditorMenu.vue?vue&type=template&id=69b48a06& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorMenu_vue_vue_type_template_id_69b48a06___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorMenu.vue?vue&type=template&id=69b48a06& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorMenu.vue?vue&type=template&id=69b48a06&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorMenu_vue_vue_type_template_id_69b48a06___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorMenu_vue_vue_type_template_id_69b48a06___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorRaw.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/PageEditorRaw.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorRaw_vue_vue_type_template_id_2ebe9f51___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorRaw.vue?vue&type=template&id=2ebe9f51& */ "./resources/js/components/PageEditorRaw.vue?vue&type=template&id=2ebe9f51&");
/* harmony import */ var _PageEditorRaw_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorRaw.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorRaw.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PageEditorRaw_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorRaw_vue_vue_type_template_id_2ebe9f51___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorRaw_vue_vue_type_template_id_2ebe9f51___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorRaw.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorRaw.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/PageEditorRaw.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorRaw_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorRaw.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorRaw.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorRaw_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorRaw.vue?vue&type=template&id=2ebe9f51&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/PageEditorRaw.vue?vue&type=template&id=2ebe9f51& ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorRaw_vue_vue_type_template_id_2ebe9f51___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorRaw.vue?vue&type=template&id=2ebe9f51& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorRaw.vue?vue&type=template&id=2ebe9f51&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorRaw_vue_vue_type_template_id_2ebe9f51___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorRaw_vue_vue_type_template_id_2ebe9f51___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorSeo.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/PageEditorSeo.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorSeo_vue_vue_type_template_id_6a078106___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorSeo.vue?vue&type=template&id=6a078106& */ "./resources/js/components/PageEditorSeo.vue?vue&type=template&id=6a078106&");
/* harmony import */ var _PageEditorSeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorSeo.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorSeo.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _PageEditorSeo_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PageEditorSeo.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _PageEditorSeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorSeo_vue_vue_type_template_id_6a078106___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorSeo_vue_vue_type_template_id_6a078106___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorSeo.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorSeo.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/PageEditorSeo.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorSeo.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader/dist/cjs.js??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorSeo.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/PageEditorSeo.vue?vue&type=template&id=6a078106&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/PageEditorSeo.vue?vue&type=template&id=6a078106& ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_template_id_6a078106___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorSeo.vue?vue&type=template&id=6a078106& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSeo.vue?vue&type=template&id=6a078106&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_template_id_6a078106___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSeo_vue_vue_type_template_id_6a078106___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/PageEditorSetting.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/PageEditorSetting.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditorSetting_vue_vue_type_template_id_8ba81e0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditorSetting.vue?vue&type=template&id=8ba81e0e& */ "./resources/js/components/PageEditorSetting.vue?vue&type=template&id=8ba81e0e&");
/* harmony import */ var _PageEditorSetting_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditorSetting.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditorSetting.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PageEditorSetting_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageEditorSetting_vue_vue_type_template_id_8ba81e0e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageEditorSetting_vue_vue_type_template_id_8ba81e0e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/PageEditorSetting.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/PageEditorSetting.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/PageEditorSetting.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSetting_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorSetting.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSetting.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSetting_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/PageEditorSetting.vue?vue&type=template&id=8ba81e0e&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/PageEditorSetting.vue?vue&type=template&id=8ba81e0e& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSetting_vue_vue_type_template_id_8ba81e0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditorSetting.vue?vue&type=template&id=8ba81e0e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditorSetting.vue?vue&type=template&id=8ba81e0e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSetting_vue_vue_type_template_id_8ba81e0e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditorSetting_vue_vue_type_template_id_8ba81e0e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);