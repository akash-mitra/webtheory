(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["PageEditor"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    PhotoPicker: _PhotoPicker_vue__WEBPACK_IMPORTED_MODULE_9__["default"]
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
      media_id: null,
      status: 'Draft',
      categories: [],
      tab: 'setting',
      isSaving: false,
      errors: {
        title: [],
        summary: [],
        metadesc: [],
        metakey: []
      },
      EDITOR_IDENTITY: 'editorjs',
      timer: null,
      autoSaveFreqSeconds: 120
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
    autoSave: function autoSave() {
      this.isValid(false) && this.initiateSave();
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
            status: _this.status,
            editor: _this.EDITOR_IDENTITY
          }, _this.postSaveProcessing, _this.handle4xxError, _this.handle5xxError);
        })["catch"](function (error) {
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
          p.media_id = data.media_id;
          p.body = JSON.parse(data.content.body_json);
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
      util.confirm("Delete this page?", "This action can not be reverted", function () {
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
              rows: 1,
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
      e.target.style.height = e.target.scrollHeight + "px";
    }
  },
  // end of methods
  beforeDestroy: function beforeDestroy() {
    window.clearInterval(this.timer);
  },
  computed: {
    url: function url() {
      return 'https://yoursite.com/' + this.id + '-' + (!!this.title ? this.title.replace(/\W+/g, '-').toLowerCase() : '');
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n/**\n * Background color for the icons of \"content\", \"meta\", \"seetings\"\n * during the mobile responsive mode\n */\n.bg-icon-primary {\n    fill: #A5B3BB\n}\ndiv.ce-paragraph {\n    /*\n        top and bottom padding must be equal to\n        ensure correct positioning of \"+\"\n        sign on left margin\n    */\n    padding-top: 0.75rem;\n    padding-bottom: 0.75rem;\n    padding-left: 0.5rem;\n    padding-right: 0.5rem;\n\n    font-size: 1rem;\n    line-height: 1.625;\n}\nh2.ce-header, h3.ce-header, h4.ce-header {\n\n    padding-top: 1rem;\n    padding-bottom: 0.25rem;\n    margin-bottom: 0;\n    margin-top: 0;\n    font-family: Georgia, Cambria, \"Times New Roman\", Times, serif;\n    -webkit-font-smoothing: antialiased;\n    -moz-osx-font-smoothing: grayscale;\n}\nh2.ce-header {\n\n    font-size: 1.875rem;\n    line-height: 1.25;\n    font-weight: 600;\n    padding-bottom: 1rem;\n    padding-top: 1rem;\n}\nh3.ce-header {\n\n    font-size: 1.875rem;\n    line-height: 1.35;\n}\nh4.ce-header {\n\n    font-size: 1.2rem;\n    font-weight: 700;\n    line-height: 1.375;\n    letter-spacing: 0.025em;\n    padding-bottom: 0.25rem;\n}\nli.cdx-list__item {\n    padding: 0.3rem 0 0.3rem 0.5rem;\n    line-height: 1.625;\n}\n\n\n/**\n * IMAGE BORDER Styles.\n *\n * Disable the original 1px border that comes with editorjs.\n * Create a new 1rem border with shadow.\n */\n.image-tool--withBorder div.image-tool__image {\n    border-style: none;\n}\n.image-tool--withBorder img {\n    /* equivalent to border p-4 shadow; */\n\n    border: 1px solid #ccc;\n    padding: 1rem;\n    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);\n}\n\n\n/**\n * IMAGE STRETCHED Styles.\n *\n * The image should stretch 100% of the container.\n */\n.ce-block--stretched, .ce-block--stretched img {\n    width: 100%;\n}\n\n/* On screens that are 768px or more, set the padding */\n@media screen and (min-width: 768px) {\n.ce-block--stretched {\n        padding-right: 6rem;\n        padding-left: 6rem;\n}\n}\n\n\n/**\n * IMAGE BACKGROUND\n *\n * Following css will reprogram the editorjs background\n * to work more like a image centering tool.\n */\n.image-tool--withBackground div.image-tool__image {\n    /* bg-white p-0; */\n    background-color: #fff;\n    padding: 0;\n}\n.image-tool--withBackground img.image-tool__image-picture {\n    max-width: 100%;\n}\n\n\n/**\n * IMAGE CAPTION BOX\n *\n * Design for the caption box below image.\n */\n.image-tool__caption {\n    /* equivalent to bg-gray-100 rounded p-2 shadow-inner border */\n    background-color: #f7fafc;\n    border-radius: 0.25rem;\n    padding: 0.5rem;\n    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);\n    border-width: 1px;\n}\n\n\n\n/* Right Side Settings Menu\n *\n * Settings menu width.\n */\n.ce-settings {\n    min-width: 120px;\n}\n\n\n/**\n * CODE BOX\n * Make sure that the code box height is not too high by default\n * Set the height to 100px.\n */\n.ce-code__textarea {\n    height: 100px;\n    min-height: 60px;\n}\n\n\n\n\n\n/*\n * Google SERP styles for Search preview\n */\n.google-header {\n    font-family: arial,sans-serif;\n    font-size: 20px;\n    line-height: 1.3;\n    cursor: pointer;\n    color: #1a0dab\n}\n.google-url {\n    font-family: arial,sans-serif;\n    font-size: 16px;\n    line-height: 1.5;\n    padding-top: 1px;\n    color: #006621\n}\n.google-desc {\n    line-height: 1.57;\n    word-wrap: break-word;\n    color: #545454;\n    font-family: arial,sans-serif;\n    font-size: 14px;\n}\n\n\n\n/* for autosizing the textareas */\n.autoheight {\n    resize: none;\n    overflow: hidden;\n    min-height: 2em;\n    max-height: 10em;\n}\n.bg-pattern {\n    background-color: #cbd5e0;\n    background-image: url(\"data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23a0aec0' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E\");\n}\n\n", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader/dist/cjs.js??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&");

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
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/vue-loader/lib/loaders/templateLoader.js):\nSyntaxError: Unexpected token (1:11192)\n    at Parser.pp$4.raise (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2757:13)\n    at Parser.pp.unexpected (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:647:8)\n    at Parser.pp$3.parseParenAndDistinguishExpression (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2252:49)\n    at Parser.pp$3.parseExprAtom (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2163:41)\n    at Parser.<anonymous> (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:6003:24)\n    at Parser.parseExprAtom (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:6129:31)\n    at Parser.pp$3.parseExprSubscripts (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2047:19)\n    at Parser.pp$3.parseMaybeUnary (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2024:17)\n    at Parser.pp$3.parseExprOps (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1966:19)\n    at Parser.pp$3.parseMaybeConditional (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1949:19)\n    at Parser.pp$3.parseMaybeAssign (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1925:19)\n    at Parser.pp$3.parsePropertyValue (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2443:87)\n    at Parser.pp$3.parseProperty (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2434:8)\n    at Parser.pp$3.parseObj (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2380:23)\n    at Parser.pp$3.parseExprAtom (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2179:17)\n    at Parser.<anonymous> (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:6003:24)\n    at Parser.parseExprAtom (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:6129:31)\n    at Parser.pp$3.parseExprSubscripts (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2047:19)\n    at Parser.pp$3.parseMaybeUnary (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2024:17)\n    at Parser.pp$3.parseExprOps (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1966:19)\n    at Parser.pp$3.parseMaybeConditional (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1949:19)\n    at Parser.pp$3.parseMaybeAssign (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1925:19)\n    at Parser.pp$3.parsePropertyValue (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2443:87)\n    at Parser.pp$3.parseProperty (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2434:8)\n    at Parser.pp$3.parseObj (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2380:23)\n    at Parser.pp$3.parseExprAtom (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2179:17)\n    at Parser.<anonymous> (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:6003:24)\n    at Parser.parseExprAtom (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:6129:31)\n    at Parser.pp$3.parseExprSubscripts (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2047:19)\n    at Parser.pp$3.parseMaybeUnary (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2024:17)\n    at Parser.pp$3.parseExprOps (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1966:19)\n    at Parser.pp$3.parseMaybeConditional (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1949:19)\n    at Parser.pp$3.parseMaybeAssign (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:1925:19)\n    at Parser.pp$3.parseExprList (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2663:20)\n    at Parser.pp$3.parseSubscripts (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2075:29)\n    at Parser.pp$3.parseExprSubscripts (/Users/akash/code/webtheory/node_modules/vue-template-es2015-compiler/buble.js:2050:21)");

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
/* empty/unused harmony star reexport *//* harmony import */ var _PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PageEditor.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
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

/***/ "./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader/dist/cjs.js??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

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



/***/ })

}]);