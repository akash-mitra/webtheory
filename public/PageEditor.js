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
/* harmony import */ var _sampleContent_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../sampleContent.js */ "./resources/js/sampleContent.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//








 // temporarily use some sample contents for development, can be deleted later


/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      editor: null,
      title: 'How to compose an article in WebTheory editor',
      intro: 'Describes various writing, editing and composing tools available under WebTheory Editor along with their usage',
      body: _sampleContent_js__WEBPACK_IMPORTED_MODULE_9__["default"],
      metakey: '',
      metadesc: '',
      category_id: 1
    };
  },
  methods: {
    initiateSave: function initiateSave() {
      var _this = this;

      this.editor.save().then(function (bodyJson) {
        var p = _this;
        util.ajax('post', '/api/pages', {
          title: p.title,
          summary: p.intro,
          body_json: JSON.stringify(bodyJson),
          metakey: p.metakey,
          metadesc: p.metadesc,
          category_id: p.category_id
        });
      })["catch"](function (error) {
        console.log('Saving failed: ', error); // this.$emit('data-prepare-error', error);
      });
    }
  },
  created: function created() {
    this.editor = new _editorjs_editorjs__WEBPACK_IMPORTED_MODULE_0___default.a({
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
      }
    });
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
exports.push([module.i, ".image-tool__caption {\n  min-height: 45px\n}\n.primary {\n  fill: #A5B3BB\n}\n\n", ""]);

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
  return _c("div", { staticClass: "w-full" }, [
    _c("div", { staticClass: "w-full px-6 border-b bg-white" }, [
      _c(
        "div",
        {
          staticClass: "mx-auto flex justify-between items-center",
          staticStyle: { "max-width": "650px" }
        },
        [
          _c("div", { staticClass: "flex justify-start items-center" }, [
            _c(
              "div",
              {
                staticClass:
                  "px-6 py-4 text-blue-600 text-sm font-bold border-b-4 border-blue-500 flex"
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
                  [_vm._v("Contents")]
                )
              ]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "px-6 py-4 text-gray-800 text-sm" }, [
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
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "px-6 py-4 text-gray-800 text-sm" }, [
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
                [_vm._v("Settings")]
              )
            ])
          ]),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass:
                "text-xs py-2 px-6 bg-blue-500 text-white rounded-lg shadow",
              on: { click: _vm.initiateSave }
            },
            [_vm._v("Save")]
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "pt-10 w-full p-6 pb-24" }, [
      _c(
        "div",
        { staticClass: "mx-auto", staticStyle: { "max-width": "650px" } },
        [
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
                "uppercase text-xs tracking-wider text-gray-700 block pb-2"
            },
            [_vm._v("\n                Title\n            ")]
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
            staticClass:
              "bg-transparent border-b-2 border-gray-400 h-24 outline-none text-blue-800 text-3xl tracking-wide w-full",
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
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "mt-12 mx-auto", staticStyle: { "max-width": "650px" } },
        [
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
                "uppercase text-xs tracking-wider text-gray-700 block pb-2"
            },
            [_vm._v("\n                Intro\n            ")]
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
              "bg-transparent border-b-2 border-gray-400 h-24 outline-none text-gray-700 text-lg tracking-wide w-full",
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
        ]
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
    return _c("div", { staticClass: "w-full p-2 bg-gray-100" }, [
      _c(
        "div",
        {
          staticClass: "max-w-4xl mx-auto bg-white -mt-16 shadow-xl px-6 pt-6"
        },
        [
          _c("div", {
            staticClass:
              "mt-4 mx-auto text-gray-700 py-4 te-typo bg-white -mr-2",
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



/***/ }),

/***/ "./resources/js/sampleContent.js":
/*!***************************************!*\
  !*** ./resources/js/sampleContent.js ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  "time": 1574068171072,
  "blocks": [{
    "type": "header",
    "data": {
      "text": "Just start typing...",
      "level": 4
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "To start composing a blog post, simply begin typing your first paragraph. Each paragraph is given its own block that can be individually structured as headers, or paragraphs, or lists etc. Within a line or para, you may choose to style a particular word or phrase in multiple ways. For example, if you just select a specific word, an inline styling menu will appear with options to style the selected word as <b>bold</b> or <i>italic</i>. Using this inline-styling menu, you can also <mark class=\"cdx-marker\">highlight a phrase</mark>, embed a <a href=\"https://www.google.com\">hyperlink</a> or even write some <code class=\"inline-code\">inline code</code>.&nbsp;"
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "If you like to create a new paragraph, just press enter and continue typing. Each paragraph creates a separate block and stored separately in a <code class=\"inline-code\">JSON</code> block inside the database."
    }
  }, {
    "type": "header",
    "data": {
      "text": "Plus Tool",
      "level": 5
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "When you press enter, you will notice a blue color \"plus\" button appear on the margin on the left side. This is called <b>Plus Tool</b>. When plus tool is visible, try pressing the <code class=\"inline-code\">tab</code> key on the keyboard. It will show you options to add Headings, Lists, Code Blocks, Tables and Pictures. Let's add a new heading."
    }
  }, {
    "type": "header",
    "data": {
      "text": "6 Different Headings",
      "level": 4
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "There are 6 different heading sizes available. After you choose the heading option from the Plus tool, you can specifically use one of these 6 headings by changing the headings from the right side margin&nbsp; where 3 horizontal dots appear. Just click on the dots and it will present you a menu to choose your heading of choice."
    }
  }, {
    "type": "header",
    "data": {
      "text": "Lists",
      "level": 4
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "Another important feature that you can access from the Plus Tool is - ability to add lists. There are 2 types of lists available:"
    }
  }, {
    "type": "list",
    "data": {
      "style": "ordered",
      "items": ["Unordered List", "Ordered List"]
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "After you have added a list, you can change the type of the list from the right side dots menu."
    }
  }, {
    "type": "header",
    "data": {
      "text": "Adding Photos and Videos",
      "level": 2
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "One of the finest ability of this editor is the ability to add photos and videos directly via the editor in a seamless fashion. Let us first consider various ways a&nbsp; photo can be added."
    }
  }, {
    "type": "list",
    "data": {
      "style": "ordered",
      "items": ["By <b>pasting a screenshot directly</b> in the editor", "By <b>uploading an image</b> via plus editor", "By <b>pasting an URL</b> of an image (In Progress)"]
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "The first option is very handy for writing tutorials or educational articles etc. where you can quickly add screenshots from your own machine in to your article."
    }
  }, {
    "type": "image",
    "data": {
      "file": {
        "url": "/storage/media/Fs6MxfFgtrVhGgulEVZ0THdb0CYOyrW5wIZW3sS9.png"
      },
      "caption": "Screenshot from my own laptop, directly pasted in to the editor<br>",
      "withBorder": false,
      "stretched": false,
      "withBackground": false
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "When a screenshot is pasted, the editor detects that it is a media file and uploads the same to a specific laravel route <code class=\"inline-code\">Route::post('/admin/media/uploadFile', 'MediaController@upload');</code>, which then process the file and stores it under the <code class=\"inline-code\">storage/media</code> directory. Next, it sends back the URL of the uploaded file back to the editor and the editor displays the file here. <mark class=\"cdx-marker\">Therefore, if you can see the pasted screenshot in the editor, this means it has already been successfully uploaded to the server.</mark>"
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "The second option also works in the same way, only difference is that it is accessed via the the Plus Tool for uploading images which are already present in your local machine."
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "<b>A note on the 3rd option</b>"
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "The 3rd option allows you the put an image just by pasting an URL pointing to an image file (e.g., <code class=\"inline-code\">https://we.com.mk/wp-content/uploads/2017/01/zakyntos-560x250.jpg</code>). When an image url is pasted, editor detects that and send the information back to <code class=\"inline-code\">/admin/media/fetchUrl</code> route via POST method. Currently there is no handler for this route in the backend. The handler should receive the URL, download the file from the remote URL to the <code class=\"inline-code\">/storage/media</code> directory and then send back the server URL of the downloaded file to the editor. Then Editor can display the image here. The response back to the editor should be in the below format."
    }
  }, {
    "type": "code",
    "data": {
      "code": "return [\n            \"success\" => 1, # 0 for failure\n            \"file\" => [ \"url\" => \"server url of the image\" ]\n];"
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "This needs to be done!&nbsp;"
    }
  }, {
    "type": "header",
    "data": {
      "text": "Embedding Video",
      "level": 4
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "Like photos, there is no mechanism to directly upload the video file from the editor. However, you can upload your file to YouTube, and paste the link here and the editor is intelligent enough to identify youtube link and display the video in an embedded way here. This is how it looks."
    }
  }, {
    "type": "embed",
    "data": {
      "service": "youtube",
      "source": "https://youtu.be/41HYjV8IxiI",
      "embed": "https://www.youtube.com/embed/41HYjV8IxiI",
      "width": 580,
      "height": 320,
      "caption": "Video embedded by directly pasting the video URL"
    }
  }, {
    "type": "header",
    "data": {
      "text": "Table Support",
      "level": 4
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "A very simple table support is provided via the Plus Tool. It does not allow you to merge rows or columns, you can not put any inline-styles or images within the table cells. Here is an example:"
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "<b>Books I read this year</b>:"
    }
  }, {
    "type": "table",
    "data": {
      "content": [["Book", "Author"], ["An Auto-biography of a Yogi", "Paramhansa Yogananda"], ["Sapiens", "Yuval Noah Harari"], ["Outliers: The story of Success", "Malcolm Gladwell"]]
    }
  }, {
    "type": "header",
    "data": {
      "text": "Upcoming Features",
      "level": 2
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "Following features are planned,"
    }
  }, {
    "type": "list",
    "data": {
      "style": "unordered",
      "items": ["Ability to embed Vimeo video", "Ability to embed Podcasts / Audio files", "Ability to attach/drag-n-drop files", "Ability to attach book references from Amazon", "And more.<br>"]
    }
  }, {
    "type": "paragraph",
    "data": {
      "text": "Enjoy!"
    }
  }],
  "version": "2.15.1"
});

/***/ })

}]);