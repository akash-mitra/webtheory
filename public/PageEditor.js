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
/* harmony import */ var _editorjs_table__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @editorjs/table */ "./node_modules/@editorjs/table/dist/bundle.js");
/* harmony import */ var _editorjs_table__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_editorjs_table__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _editorjs_image__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @editorjs/image */ "./node_modules/@editorjs/image/dist/bundle.js");
/* harmony import */ var _editorjs_image__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_editorjs_image__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _editorjs_embed__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @editorjs/embed */ "./node_modules/@editorjs/embed/dist/bundle.js");
/* harmony import */ var _editorjs_embed__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_editorjs_embed__WEBPACK_IMPORTED_MODULE_8__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      editor: null,
      id: 0,
      title: '',
      intro: '',
      body: {},
      metakey: '',
      metadesc: '',
      category_id: 1,
      status: 'Draft',
      categories: [],
      tab: 'content',
      isSaving: false
    };
  },

  /**--------------------------------------------------------------------------
   * Perform these functions when this component is created 
   * for the first time only.
   */
  created: function created() {
    this.fetchContentAndLoadEditor();
    this.fetchCategoryListFromServer();
  },
  // end of created
  mounted: function mounted() {
    this.focusInput();
  },
  methods: {
    // simple front-end validations before starting
    // the saving process. Mandatory fields checking.
    validateBeforeSave: function validateBeforeSave() {
      if (this.title.length === 0 || this.title.length >= 100 || this.intro.length === 0 || this.intro.length >= 1048) return false;
      return true;
    },
    getSaveUrl: function getSaveUrl() {
      if (this.id > 0) return '/api/pages/' + this.id;else return '/api/pages';
    },
    getSaveMethod: function getSaveMethod() {
      if (this.id > 0) return 'put';else return 'post';
    },
    initiateSave: function initiateSave() {
      var _this = this;

      if (this.validateBeforeSave()) {
        this.isSaving = true;
        this.editor.save().then(function (bodyJson) {
          var p = _this;
          util.ajax(_this.getSaveMethod(), _this.getSaveUrl(), {
            id: _this.id,
            title: p.title,
            summary: p.intro,
            body_json: JSON.stringify(bodyJson),
            metakey: p.metakey,
            metadesc: p.metadesc,
            category_id: p.category_id,
            status: p.status
          }, _this.postSaveProcessing);
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
        p.id = id; // change the address bar URL to en edit page url

        p.$router.replace({
          path: '/app/pages/' + id
        });
      } // console.table({
      //     method: p.getSaveMethod(),
      //     url: p.getSaveUrl(),
      //     "ID sent": p.id,
      //     "ID returned": id
      // })


      this.isSaving = false;
      Toast.fire({
        icon: 'success',
        titleText: 'Page Saved Successfully' // text: 'The page has been saved successfully'

      });
    },
    // end of postSaveProcessing
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
        var _p = this;

        util.ajax('get', '/api/pages/' + this.$route.params.id, {}, function (data) {
          _p.id = data.id;
          _p.title = data.title;
          _p.intro = data.summary;
          _p.metakey = data.metakey;
          _p.metadesc = data.metadesc;
          _p.category_id = data.category_id;
          _p.status = data.status;
          _p.body = JSON.parse(data.content.body_json);
          _p.editor = _p.loadEditorTool();
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
            config: {
              placeholder: 'Enter a sub-heading...'
            }
          },
          // allows you to highlight inline texts
          marker: _editorjs_marker__WEBPACK_IMPORTED_MODULE_5___default.a,
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
            "class": _editorjs_table__WEBPACK_IMPORTED_MODULE_6___default.a,
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
                byFile: '/server/media/uploadFile',
                // Backend file uploader endpoint
                byUrl: '/server/media/fetchUrl' // Endpoint that provides uploading by Url

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
    }
  },
  // end of methods
  computed: {
    url: function url() {
      return 'https://yoursite.com/' + this.id + '-' + this.title.replace(/\W+/g, '-').toLowerCase();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".te-typo h1, .te-typo h2, .te-typo h3, .te-typo h4, .te-typo h5, .te-typo h6 {\n  color: #2a4365;\n  -webkit-font-smoothing: antialiased;\n  -moz-osx-font-smoothing: grayscale;\n}\n.te-typo h1, .te-typo h2 {\n  font-size: 2.25rem;\n}\n.te-typo h3, .te-typo h4 {\n  font-size: 1.875rem;\n}\n.te-typo h5, .te-typo h6 {\n  font-size: 1.5rem;\n}\n.te-typo h1, .te-typo h3, .te-typo h5 {\n  font-weight: 600;\n}\n.te-typo ul > li, .te-typo ol > li,\n.te-typo .ce-paragraph,\n.te-typo p {\n  line-height: 1.6em;\n  -webkit-font-smoothing: antialiased;\n  -moz-osx-font-smoothing: grayscale;\n  color: #2d3748;\n}\n.te-typo b {\n  font-weight: 700;\n}\n.te-typo code {\n  background-color: #fff5f5;\n  color: #c53030;\n  padding-left: 0.5rem;\n  padding-right: 0.5rem;\n  margin-left: 0.25rem;\n  margin-right: 0.25rem;\n  border-radius: 0.125rem;\n  font-family: Menlo, Monaco, Consolas, \"Liberation Mono\", \"Courier New\", monospace;\n}\n.te-typo mark {\n  background-color: #fefcbf;\n  padding-top: 0.25rem;\n  padding-bottom: 0.25rem;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".image-tool__caption {\n  min-height: 45px\n}\n.primary {\n  fill: #A5B3BB\n}\n.google-header {\n  font-family: arial,sans-serif;\n  font-size: 20px;\n  line-height: 1.3;\n  cursor: pointer;\n  color: #1a0dab\n}\n.google-url {\n  font-family: arial,sans-serif;\n  font-size: 16px;\n  line-height: 1.5;\n  padding-top: 1px;\n  color: #006621\n}\n.google-desc {\n  line-height: 1.57;\n  word-wrap: break-word;\n  color: #545454;\n  font-family: arial,sans-serif;\n  font-size: 14px;\n}\n\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--8-2!./node_modules/sass-loader/dist/cjs.js??ref--8-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--8-2!../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=style&index=1&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss&");

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

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&");

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
    {
      staticClass: "w-full",
      on: {
        keydown: function($event) {
          if (!$event.type.indexOf("key") && $event.keyCode !== 83) {
            return null
          }
          if (!$event.ctrlKey) {
            return null
          }
          if ($event.shiftKey || $event.altKey || $event.metaKey) {
            return null
          }
          $event.preventDefault()
          $event.stopPropagation()
          return _vm.initiateSave($event)
        }
      }
    },
    [
      _c("div", { staticClass: "w-full px-6 border-b bg-white" }, [
        _c(
          "div",
          {
            staticClass: "max-w-4xl mx-auto flex justify-between items-center"
          },
          [
            _c("div", { staticClass: "flex justify-start items-center" }, [
              _c(
                "div",
                {
                  staticClass:
                    "pr-6 py-4 text-xs uppercase text-gray-800 cursor-pointer",
                  class:
                    _vm.tab === "content"
                      ? "px-6 text-blue-600 font-bold border-b-4 border-blue-500"
                      : "",
                  on: {
                    click: function($event) {
                      _vm.tab = "content"
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
                        viewBox: "0 0 24 24"
                      }
                    },
                    [
                      _c("path", {
                        staticClass: "primary",
                        attrs: {
                          d:
                            "M6 2h6v6c0 1.1.9 2 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm2 11a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2H8zm0 4a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2H8z"
                        }
                      }),
                      _c("polygon", {
                        staticClass: "secondary",
                        attrs: { points: "14 2 20 8 14 8" }
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
                    _vm.tab === "meta"
                      ? "text-blue-600 font-bold border-b-4 border-blue-500"
                      : "",
                  on: {
                    click: function($event) {
                      _vm.tab = "meta"
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
                        viewBox: "0 0 24 24"
                      }
                    },
                    [
                      _c("path", {
                        staticClass: "primary",
                        attrs: { d: "M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" }
                      }),
                      _c("path", {
                        staticClass: "secondary",
                        attrs: {
                          d:
                            "M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                        }
                      })
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "span",
                    { staticClass: "hidden sm:inline-block tracking-wider" },
                    [_vm._v("Meta")]
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
                    _vm.tab === "setting"
                      ? "text-blue-600 font-bold border-b-4 border-blue-500"
                      : "",
                  on: {
                    click: function($event) {
                      _vm.tab = "setting"
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
                        viewBox: "0 0 24 24"
                      }
                    },
                    [
                      _c("path", {
                        staticClass: "secondary",
                        attrs: {
                          "fill-rule": "evenodd",
                          d:
                            "M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"
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
              )
            ]),
            _vm._v(" "),
            _c(
              "t-button",
              {
                attrs: { isLoading: _vm.isSaving },
                nativeOn: {
                  click: function($event) {
                    return _vm.initiateSave($event)
                  }
                }
              },
              [_vm._v("\n                Save\n            ")]
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.tab === "content",
              expression: "tab==='content'"
            }
          ],
          staticClass: "w-full",
          attrs: { id: "page-contents" }
        },
        [
          _c("div", { staticClass: "pt-10 w-full p-6 pb-24" }, [
            _c("div", { staticClass: "mx-auto max-w-4xl" }, [
              _c(
                "label",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.title.length === 0,
                      expression: "title.length===0"
                    }
                  ],
                  staticClass:
                    "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
                },
                [_vm._v("\n                    Title\n                ")]
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
                  "px-6 bg-transparent border-b-2 border-gray-400 h-24 outline-none text-blue-800 text-3xl tracking-wide w-full",
                attrs: { name: "title", placeholder: "Title of your story" },
                domProps: { value: _vm.title },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.title = $event.target.value
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "mt-12 mx-auto  max-w-4xl" }, [
              _c(
                "label",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.intro.length === 0,
                      expression: "intro.length===0"
                    }
                  ],
                  staticClass:
                    "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
                },
                [_vm._v("\n                    Intro\n                ")]
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
                staticClass:
                  "px-6 bg-transparent h-24 outline-none text-gray-700 text-lg tracking-wide w-full",
                attrs: {
                  name: "intro",
                  placeholder:
                    "Provide a 3/4 lines of introduction to your story..."
                },
                domProps: { value: _vm.intro },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.intro = $event.target.value
                  }
                }
              })
            ])
          ]),
          _vm._v(" "),
          _vm._m(0)
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.tab === "meta",
              expression: "tab==='meta'"
            }
          ],
          staticClass: "w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20",
          attrs: { id: "page-meta" }
        },
        [
          _c(
            "div",
            { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" },
            [_vm._v("Meta Information")]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "bg-white rounded md:flex w-full py-6 px-4 border-t-2 border-blue-400 shadow"
            },
            [
              _c("div", { staticClass: "w-full md:w-1/2 px-4" }, [
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
                      "\n                    Good meta descriptions are short blurbs that describe accurately the content of the page.\n                    This gives Google and other search engines a summary of what the page is about. \n                "
                    )
                  ]
                ),
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
                  class: _vm.metadesc.length === 0 ? "border-red-400" : "",
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
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "w-full mt-4 md:mt-0 md:w-1/2 px-4" }, [
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
                      "\n                    A series of keywords you deem relevant to the page in question. These are used to automatically generate tags for the page.\n                    Note that Google doesn’t use meta keywords in its ranking algorithm.\n                "
                    )
                  ]
                ),
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
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" },
            [_vm._v("Organize")]
          ),
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
                      "\n                    You may organize your pages under various categories. \n                    Category names can be used to create menu items that can link all the pages under the same category.\n                "
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
                        {
                          key: category.key,
                          domProps: { value: category.key }
                        },
                        [
                          _vm._v(
                            "                        \n                                " +
                              _vm._s(category.value) +
                              "\n                        "
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
          _c(
            "div",
            { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" },
            [_vm._v("Search Engine Preview")]
          ),
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
                      "\n                    This is how this page will appear in Google search when using the page meta description.\n                    Search engines may use meta description as snippets for your pages or \n                    a more relevant section of your page's visible text, if that fits better with a user's query.\n                "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "mt-2 w-full bg-gray-100 rounded-lg p-4 border"
                  },
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
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.tab === "setting",
              expression: "tab==='setting'"
            }
          ],
          staticClass: "w-full max-w-4xl mx-auto px-4 xl:px-0 pb-20",
          attrs: { id: "page-setting" }
        },
        [
          _c(
            "div",
            { staticClass: "text-sm text-gray-600 pt-10 pb-3 uppercase" },
            [_vm._v("\n            Publication\n        ")]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "bg-white rounded w-full py-6 px-4 border-t-2 border-blue-400 shadow"
            },
            [
              _c(
                "t-toggle",
                {
                  staticClass: "mb-4",
                  attrs: { "true-value": "Live", "false-value": "Draft" },
                  model: {
                    value: _vm.status,
                    callback: function($$v) {
                      _vm.status = $$v
                    },
                    expression: "status"
                  }
                },
                [
                  _c("div", { staticClass: "ml-2 text-gray-700 text-sm" }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(_vm.status) +
                        "\n                "
                    )
                  ])
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "w-full mb-2 text-xs text-gray-700" }, [
                _vm._v(
                  "\n                Only Live page will be accessible to site visitors. \n            "
                )
              ])
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "pt-10 pb-3 text-right" }, [
            _c(
              "span",
              {
                staticClass:
                  "text-sm text-grey-600 hover:text-red-600 cursor-pointer",
                on: { click: _vm.deletePage }
              },
              [_vm._v("\n                Delete this page \n            ")]
            )
          ])
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "w-full p-2 bg-gray-100 pb-20" }, [
      _c(
        "div",
        {
          staticClass:
            "max-w-4xl mx-auto bg-white -mt-16 shadow-xl px-6 pt-6 border-t-2 border-blue-400"
        },
        [
          _c("div", {
            staticClass: "mx-auto text-gray-700 pb-4 te-typo bg-white -mr-2",
            attrs: { id: "tensor-editor" }
          })
        ]
      )
    ])
  }
]
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
/* empty/unused harmony star reexport *//* harmony import */ var _PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PageEditor.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _PageEditor_vue_vue_type_style_index_1_lang_scss___WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./PageEditor.vue?vue&type=style&index=1&lang=scss& */ "./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");







/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_4__["default"])(
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
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss& ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_1_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--8-2!../../../node_modules/sass-loader/dist/cjs.js??ref--8-3!../../../node_modules/vue-loader/lib??vue-loader-options!./PageEditor.vue?vue&type=style&index=1&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=style&index=1&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_1_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_1_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_1_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_1_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_8_2_node_modules_sass_loader_dist_cjs_js_ref_8_3_node_modules_vue_loader_lib_index_js_vue_loader_options_PageEditor_vue_vue_type_style_index_1_lang_scss___WEBPACK_IMPORTED_MODULE_0___default.a); 

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