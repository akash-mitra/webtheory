(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["TemplateEditor"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateEditor.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TemplateEditor.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      tab: 'template',
      isSaving: false,
      id: 0,
      type: null,
      name: null,
      description: null,
      url: 'https://source.unsplash.com/500x310/?blog,page',
      sourceCode: null,
      active: false
    };
  },
  created: function created() {
    this.fetchContentAndLoadEditor();
  },
  components: {
    editor: __webpack_require__(/*! vue2-ace-editor */ "./node_modules/vue2-ace-editor/index.js")
  },
  methods: {
    editorInit: function editorInit() {
      // require('brace/ext/language_tools') //language extension prerequsite...
      __webpack_require__(/*! brace/mode/html */ "./node_modules/brace/mode/html.js"); // require('brace/mode/javascript')    //language
      // require('brace/mode/less')


      __webpack_require__(/*! brace/theme/twilight */ "./node_modules/brace/theme/twilight.js"); // require('brace/snippets/javascript') //snippet

    },
    // simple front-end validations before starting
    // the saving process. Mandatory fields checking.
    isValid: function isValid() {
      if (!this.name) {
        util.notifyError('Template has no name', 'Provide a name for this template');
        return false;
      }

      if (this.name.length >= 100) {
        util.notifyError('Template name too long!', 'Keep name within maximum 100 characters.');
        return false;
      }

      if (!this.description) {
        util.notifyError('Provide a description', 'Write a few lines of description for this template before saving.');
        return false;
      }

      if (this.description.length >= 1048) {
        util.notifyError('Description too long', 'Keep description within about 1000 characters');
        return false;
      }

      if (!this.type) {
        util.notifyError('Template must have a type', 'Select any one type for this template, e.g. "Home" or "Single" etc.');
        return false;
      }

      return true;
    },
    getSaveUrl: function getSaveUrl() {
      if (this.id > 0) return '/api/templates/' + this.id;else return '/api/templates';
    },
    getSaveMethod: function getSaveMethod() {
      if (this.id > 0) return 'put';else return 'post';
    },
    initiateSave: function initiateSave() {
      if (this.isValid()) {
        this.isSaving = true;
        util.ajax(this.getSaveMethod(), this.getSaveUrl(), {
          id: this.id,
          name: this.name,
          description: this.description,
          code: this.sourceCode,
          type: this.type,
          media_url: this.url,
          active: this.active
        }, this.postSaveProcessing);
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
          path: '/app/templates/' + id
        });
      }

      this.isSaving = false;
      util.toast({
        icon: 'success',
        titleText: 'Template Saved Successfully' // text: 'The page has been saved successfully'

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
        this.sourceCode = 'Retrieving information from the server....'; // download data from server...

        var p = this;
        util.ajax('get', '/api/templates/' + this.$route.params.id, {}, function (data) {
          p.id = data.id;
          p.name = data.name;
          p.description = data.description;
          p.type = data.type;
          p.url = data.media_url;
          p.sourceCode = data.code;
          p.active = data.active;
        });
      }
    },
    // end of fetchContentAndLoadEditor
    deletePage: function deletePage() {
      var p = this;
      util.confirm("Delete this template?", "This action can not be reverted", function () {
        util.ajax('delete', '/api/templates/' + p.id, {}, function (response) {
          util.notifySuccess('Deleted', 'The template has been successfully deleted');
          p.$router.push('/app/templates');
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateEditor.vue?vue&type=template&id=64d6e632&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TemplateEditor.vue?vue&type=template&id=64d6e632& ***!
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
  return _c("div", { staticClass: "max-w-5xl mx-auto" }, [
    _c(
      "div",
      { staticClass: "px-2 my-6 w-full flex justify-between items-center" },
      [
        _c("h2", { staticClass: "text-gray-600 text-2xl flex items-center" }, [
          _vm._v("Template Editor")
        ]),
        _vm._v(" "),
        _c(
          "t-button",
          {
            attrs: { loadingWheel: _vm.isSaving },
            nativeOn: {
              click: function($event) {
                return _vm.initiateSave($event)
              }
            }
          },
          [_vm._v("\n                Save\n        ")]
        )
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "px-2 w-full flex justify-start items-center mt-8" },
      [
        _c(
          "div",
          {
            staticClass: "px-6 text-sm tracking-wide uppercase cursor-pointer",
            class:
              _vm.tab === "template"
                ? "text-gray-700 py-2 1border-b-4 border-blue-500"
                : "text-gray-500 py-2",
            on: {
              click: function($event) {
                _vm.tab = "template"
              }
            }
          },
          [_vm._v("Template")]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "px-6 text-sm tracking-wide uppercase cursor-pointer",
            class:
              _vm.tab === "source"
                ? "text-gray-700 py-2 1border-b-4 border-blue-500"
                : "text-gray-500 py-2",
            on: {
              click: function($event) {
                _vm.tab = "source"
              }
            }
          },
          [_vm._v("Source")]
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
            value: _vm.tab === "template",
            expression: "tab==='template'"
          }
        ],
        staticClass:
          "w-full bg-white px-6 py-10 border-t border-blue-400 rounded mb-12"
      },
      [
        _c("div", { staticClass: "w-full sm:flex mb-4" }, [
          _c(
            "label",
            {
              staticClass: "block w-full sm:w-1/4 text-sm py-1 px-3",
              attrs: { for: "templateName" }
            },
            [_vm._v("Name")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.name,
                expression: "name"
              }
            ],
            ref: "name",
            staticClass:
              "w-full sm:w-3/4 max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none",
            attrs: { type: "text", id: "templateName" },
            domProps: { value: _vm.name },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.name = $event.target.value
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "w-full sm:flex mb-8" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("textarea", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.description,
                expression: "description"
              }
            ],
            staticClass:
              "w-full sm:w-3/4 text-sm max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none",
            attrs: { id: "templateDescription" },
            domProps: { value: _vm.description },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.description = $event.target.value
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "w-full sm:flex mb-8" }, [
          _vm._m(1),
          _vm._v(" "),
          _c("div", { staticClass: "w-full sm:w-3/4 flex flex-wrap" }, [
            _c(
              "div",
              {
                staticClass:
                  "w-40 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative",
                class:
                  _vm.type === "home" ? "bg-green-100 border-green-400" : "",
                on: {
                  click: function($event) {
                    _vm.type = "home"
                  }
                }
              },
              [
                _vm.type === "home"
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white",
                        staticStyle: {
                          position: "absolute",
                          top: "-10px",
                          right: "-10px"
                        }
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "fill-current",
                            attrs: {
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 469 469"
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                d:
                                  "M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"
                              }
                            })
                          ]
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("h3", { staticClass: "text-sm uppercase" }, [
                  _vm._v("Home")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "text-xs text-gray-700" }, [
                  _vm._v("Template for the home page of your blog")
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative",
                class:
                  _vm.type === "single" ? "bg-green-100 border-green-400" : "",
                on: {
                  click: function($event) {
                    _vm.type = "single"
                  }
                }
              },
              [
                _vm.type === "single"
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white",
                        staticStyle: {
                          position: "absolute",
                          top: "-10px",
                          right: "-10px"
                        }
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "fill-current",
                            attrs: {
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 469 469"
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                d:
                                  "M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"
                              }
                            })
                          ]
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("h3", { staticClass: "text-sm uppercase" }, [
                  _vm._v("Single")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "text-xs text-gray-700" }, [
                  _vm._v("Template for a single blog article page")
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative",
                class:
                  _vm.type === "category"
                    ? "bg-green-100 border-green-400"
                    : "",
                on: {
                  click: function($event) {
                    _vm.type = "category"
                  }
                }
              },
              [
                _vm.type === "category"
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white",
                        staticStyle: {
                          position: "absolute",
                          top: "-10px",
                          right: "-10px"
                        }
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "fill-current",
                            attrs: {
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 469 469"
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                d:
                                  "M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"
                              }
                            })
                          ]
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("h3", { staticClass: "text-sm uppercase" }, [
                  _vm._v("Category")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "text-xs text-gray-700" }, [
                  _vm._v("Template for showing all the pages from a category")
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative",
                class:
                  _vm.type === "profile" ? "bg-green-100 border-green-400" : "",
                on: {
                  click: function($event) {
                    _vm.type = "profile"
                  }
                }
              },
              [
                _vm.type === "profile"
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white",
                        staticStyle: {
                          position: "absolute",
                          top: "-10px",
                          right: "-10px"
                        }
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "fill-current",
                            attrs: {
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 469 469"
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                d:
                                  "M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"
                              }
                            })
                          ]
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("h3", { staticClass: "text-sm uppercase" }, [
                  _vm._v("Profile")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "text-xs text-gray-700" }, [
                  _vm._v("Template for showing a user profile page")
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass:
                  "w-40 h-32 m-3 p-4 border cursor-pointer rounded-lg shadow-md relative",
                class:
                  _vm.type === "forum" ? "bg-green-100 border-green-400" : "",
                on: {
                  click: function($event) {
                    _vm.type = "forum"
                  }
                }
              },
              [
                _vm.type === "forum"
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "w-8 h-8 p-2 bg-green-500 text-white rounded-full border border-white",
                        staticStyle: {
                          position: "absolute",
                          top: "-10px",
                          right: "-10px"
                        }
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "fill-current",
                            attrs: {
                              xmlns: "http://www.w3.org/2000/svg",
                              viewBox: "0 0 469 469"
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                d:
                                  "M463 96l-22-22c-9-8-24-8-33 0L180 302 61 183c-9-9-24-9-33 0L7 205c-9 9-9 23 0 32l157 158a23 23 0 0032 0l266-266c9-9 9-24 1-33z"
                              }
                            })
                          ]
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("h3", { staticClass: "text-sm uppercase" }, [
                  _vm._v("Forum")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "text-xs text-gray-700" }, [
                  _vm._v("Template for showing a single forum post")
                ])
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "w-full sm:flex mb-4" }, [
          _vm._m(2),
          _vm._v(" "),
          _c("div", { staticClass: "w-full sm:w-3/4" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.url,
                  expression: "url"
                }
              ],
              staticClass:
                "w-full max-w-lg text-sm max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none",
              attrs: { type: "text", id: "templateUrl" },
              domProps: { value: _vm.url },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.url = $event.target.value
                }
              }
            })
          ])
        ])
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
            value: _vm.tab === "source",
            expression: "tab==='source'"
          }
        ],
        staticClass: "w-full rounded mb-12"
      },
      [
        _c("editor", {
          attrs: {
            lang: "html",
            theme: "twilight",
            width: "100%",
            height: "500"
          },
          on: { init: _vm.editorInit },
          model: {
            value: _vm.sourceCode,
            callback: function($$v) {
              _vm.sourceCode = $$v
            },
            expression: "sourceCode"
          }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "w-full sm:w-1/4 text-sm py-1 px-3" }, [
      _c("label", { attrs: { for: "templateDescription" } }, [
        _vm._v("Description")
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "text-xs text-gray-600 py-2" }, [
        _vm._v("Describe the motivation behind this template")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "w-full sm:w-1/4 text-sm py-1 px-3" }, [
      _c("p", [_vm._v("Type")]),
      _vm._v(" "),
      _c("p", { staticClass: "text-xs text-gray-600 py-2" }, [
        _vm._v("What kind of blog pages should use this template design?")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "w-full sm:w-1/4 text-sm py-1 px-3" }, [
      _c("label", { attrs: { for: "templateUrl" } }, [
        _vm._v("Template Image URL")
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "text-xs text-gray-600 py-2" }, [
        _vm._v("Provide an image URL to be used as template icon image")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/TemplateEditor.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/TemplateEditor.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TemplateEditor_vue_vue_type_template_id_64d6e632___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TemplateEditor.vue?vue&type=template&id=64d6e632& */ "./resources/js/components/TemplateEditor.vue?vue&type=template&id=64d6e632&");
/* harmony import */ var _TemplateEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TemplateEditor.vue?vue&type=script&lang=js& */ "./resources/js/components/TemplateEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TemplateEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TemplateEditor_vue_vue_type_template_id_64d6e632___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TemplateEditor_vue_vue_type_template_id_64d6e632___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/TemplateEditor.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/TemplateEditor.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/TemplateEditor.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TemplateEditor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/TemplateEditor.vue?vue&type=template&id=64d6e632&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/TemplateEditor.vue?vue&type=template&id=64d6e632& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateEditor_vue_vue_type_template_id_64d6e632___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TemplateEditor.vue?vue&type=template&id=64d6e632& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateEditor.vue?vue&type=template&id=64d6e632&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateEditor_vue_vue_type_template_id_64d6e632___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateEditor_vue_vue_type_template_id_64d6e632___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);