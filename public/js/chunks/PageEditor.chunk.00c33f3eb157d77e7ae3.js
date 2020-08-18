(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["PageEditor"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/PageEditor.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/PageEditor.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/akash/code/webtheory/resources/js/components/PageEditor.vue: Unexpected token, expected \";\" (209:5)\n\n\u001b[0m \u001b[90m 207 | \u001b[39m            \u001b[36mthis\u001b[39m\u001b[33m.\u001b[39mcurrentDisplayOrder\u001b[33m++\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 208 | \u001b[39m        }\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 209 | \u001b[39m    }\u001b[33m,\u001b[39m \u001b[90m// end of methods\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m     | \u001b[39m     \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 210 | \u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 211 | \u001b[39m    beforeDestroy() {\u001b[0m\n\u001b[0m \u001b[90m 212 | \u001b[39m        window\u001b[33m.\u001b[39mclearInterval(\u001b[36mthis\u001b[39m\u001b[33m.\u001b[39mtimer)\u001b[0m\n    at Parser._raise (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:742:17)\n    at Parser.raiseWithData (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:735:17)\n    at Parser.raise (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:729:17)\n    at Parser.unexpected (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:8779:16)\n    at Parser.semicolon (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:8761:40)\n    at Parser.parseExportDefaultExpression (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:12307:12)\n    at Parser.parseExport (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:12208:31)\n    at Parser.parseStatementContent (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:11208:27)\n    at Parser.parseStatement (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:11104:17)\n    at Parser.parseBlockOrModuleBlockBody (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:11679:25)\n    at Parser.parseBlockBody (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:11665:10)\n    at Parser.parseTopLevel (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:11035:10)\n    at Parser.parse (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:12671:10)\n    at parse (/Users/akash/code/webtheory/node_modules/@babel/parser/lib/index.js:12722:38)\n    at parser (/Users/akash/code/webtheory/node_modules/@babel/core/lib/parser/index.js:54:34)\n    at parser.next (<anonymous>)\n    at normalizeFile (/Users/akash/code/webtheory/node_modules/@babel/core/lib/transformation/normalize-file.js:93:38)\n    at normalizeFile.next (<anonymous>)\n    at run (/Users/akash/code/webtheory/node_modules/@babel/core/lib/transformation/index.js:31:50)\n    at run.next (<anonymous>)\n    at Function.transform (/Users/akash/code/webtheory/node_modules/@babel/core/lib/transform.js:27:41)\n    at transform.next (<anonymous>)\n    at step (/Users/akash/code/webtheory/node_modules/gensync/index.js:254:32)\n    at /Users/akash/code/webtheory/node_modules/gensync/index.js:266:13\n    at async.call.result.err.err (/Users/akash/code/webtheory/node_modules/gensync/index.js:216:11)");

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
    { staticClass: "w-full bg-white" },
    [
      _c("PageEditorMenu", {
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
          staticClass: "w-full",
          attrs: { id: "page-contents" }
        },
        [
          _c("div", { staticClass: "pt-10 w-full" }, [
            _c(
              "div",
              { staticClass: "w-full mx-auto max-w-5xl" },
              [
                _c(
                  "label",
                  {
                    staticClass:
                      "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
                  },
                  [
                    _vm._v("\n                    Title\n                    "),
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
              { staticClass: "mt-12 mx-auto max-w-5xl" },
              [
                _c(
                  "label",
                  {
                    staticClass:
                      "px-6 uppercase text-xs tracking-wider text-gray-700 block pb-2"
                  },
                  [
                    _vm._v("\n                    Intro\n                    "),
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
                    "border autoheight h-auto px-6 bg-transparent outline-none text-gray-700 text-lg tracking-wide w-full placeholder-gray-700",
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
          _c(
            "div",
            { staticClass: "max-w-5xl mx-auto mt-12 border" },
            _vm._l(_vm.contents, function(content) {
              return _c(
                "div",
                { staticClass: "w-full mt-12" },
                [
                  content.type === "raw"
                    ? _c("PageEditorRaw", { attrs: { content: content } })
                    : _vm._e(),
                  _vm._v(" "),
                  content.type === "editorjs"
                    ? _c("PageEditorJs", {
                        attrs: { data: content.body_json },
                        on: { change: _vm.contentChange }
                      })
                    : _vm._e()
                ],
                1
              )
            }),
            0
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "max-w-5xl mx-auto mt-12 border flex items-center justify-between"
            },
            [
              _c(
                "span",
                {
                  staticClass: "px-4 py-2 bg-blue-500 text-white rounded",
                  on: { click: _vm.addEditor }
                },
                [_vm._v("Add Content")]
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
                        value: _vm.currentEditorType,
                        expression: "currentEditorType"
                      }
                    ],
                    staticClass:
                      "block appearance-none w-full bg-gray-100 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg leading-tight focus:outline-none focus:shadow-outline border",
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
                        _vm.currentEditorType = $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      }
                    }
                  },
                  _vm._l(_vm.editorTypes, function(option) {
                    return _c("option", { domProps: { value: option.value } }, [
                      _vm._v(_vm._s(option.text))
                    ])
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
            ]
          )
        ]
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

/***/ "./resources/js/components/PageEditor.vue":
/*!************************************************!*\
  !*** ./resources/js/components/PageEditor.vue ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageEditor_vue_vue_type_template_id_a5de30f2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageEditor.vue?vue&type=template&id=a5de30f2& */ "./resources/js/components/PageEditor.vue?vue&type=template&id=a5de30f2&");
/* harmony import */ var _PageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageEditor.vue?vue&type=script&lang=js& */ "./resources/js/components/PageEditor.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _PageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _PageEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





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
/*! no static exports found */
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



/***/ })

}]);