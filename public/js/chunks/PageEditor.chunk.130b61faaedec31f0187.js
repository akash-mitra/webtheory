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
      _this.contents = data.contents;
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
    isJustCreated: function isJustCreated() {
      return this.id === 0;
    },
    addContentBlock: function addContentBlock(type) {
      this.contents.push({
        type: type,
        body_html: '',
        body_json: {
          blocks: []
        },
        display_order: this.maxDisplayOrder + 1,
        changed: true
      });
      this.maxDisplayOrder++;
    },
    removeContentBlock: function removeContentBlock(index) {
      this.contents.splice(index, 1);
    },
    downContentBlock: function downContentBlock(index) {
      this.contents.splice(index + 1, 0, this.contents.splice(index, 1)[0]);
    },
    upContentBlock: function upContentBlock(index) {
      this.contents.splice(index - 1, 0, this.contents.splice(index, 1)[0]);
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
          contents: this.contents,
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
    resizeInput: function resizeInput(e) {
      e.target.style.height = 'auto';
      e.target.style.height = e.target.scrollHeight + 'px';
    }
  } // end of methods

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
            on: {
              add: _vm.addContentBlock,
              delete: _vm.removeContentBlock,
              down: _vm.downContentBlock,
              up: _vm.upContentBlock
            }
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
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/vue-loader/lib/index.js):\nError: ENOENT: no such file or directory, open '/Users/akash/code/webtheory/resources/js/components/PageEditorContent.vue'");

/***/ }),

/***/ "./resources/js/components/PageEditorContentBlocks.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/PageEditorContentBlocks.vue ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/vue-loader/lib/index.js):\nError: ENOENT: no such file or directory, open '/Users/akash/code/webtheory/resources/js/components/PageEditorContentBlocks.vue'");

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

/***/ "./resources/js/components/PageEditorMenu.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/PageEditorMenu.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/vue-loader/lib/index.js):\nError: ENOENT: no such file or directory, open '/Users/akash/code/webtheory/resources/js/components/PageEditorMenu.vue'");

/***/ }),

/***/ "./resources/js/components/PageEditorSeo.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/PageEditorSeo.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/vue-loader/lib/index.js):\nError: ENOENT: no such file or directory, open '/Users/akash/code/webtheory/resources/js/components/PageEditorSeo.vue'");

/***/ }),

/***/ "./resources/js/components/PageEditorSetting.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/PageEditorSetting.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/vue-loader/lib/index.js):\nError: ENOENT: no such file or directory, open '/Users/akash/code/webtheory/resources/js/components/PageEditorSetting.vue'");

/***/ })

}]);