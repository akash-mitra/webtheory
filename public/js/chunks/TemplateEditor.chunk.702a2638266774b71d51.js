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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      tab: 'files',
      isSaving: false,
      id: 0,
      files: [],
      name: null,
      description: null,
      url: 'https://source.unsplash.com/500x310/?blog,page',
      active: false,
      parameters: [// {name: "", type: "list", options: "", value: "" },
      ]
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
    addTemplateFile: function addTemplateFile() {
      this.parameters.push({
        name: '',
        type: 'text',
        options: '',
        value: ''
      });
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
          type: this.type,
          media_url: this.url,
          active: this.active,
          parameters: JSON.stringify(this.parameters)
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
        var p = this;
        util.ajax('get', '/api/templates/' + this.$route.params.id, {}, function (data) {
          p.id = data.id;
          p.name = data.name;
          p.description = data.description;
          p.files = data.files;
          p.url = data.media_url;
          p.active = data.active;
          p.parameters = JSON.parse(data.parameters);
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
              _vm.tab === "general"
                ? "text-gray-700 py-2 border-b-4 border-blue-500"
                : "text-gray-500 py-2",
            on: {
              click: function($event) {
                _vm.tab = "general"
              }
            }
          },
          [_vm._v("general")]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "px-6 text-sm tracking-wide uppercase cursor-pointer",
            class:
              _vm.tab === "files"
                ? "text-gray-700 py-2 border-b-4 border-blue-500"
                : "text-gray-500 py-2",
            on: {
              click: function($event) {
                _vm.tab = "files"
              }
            }
          },
          [_vm._v("Files")]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "px-6 text-sm tracking-wide uppercase cursor-pointer",
            class:
              _vm.tab === "parameters"
                ? "text-gray-700 py-2 border-b-4 border-blue-500"
                : "text-gray-500 py-2",
            on: {
              click: function($event) {
                _vm.tab = "parameters"
              }
            }
          },
          [_vm._v("Parameters")]
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
            value: _vm.tab === "files",
            expression: "tab==='files'"
          }
        ],
        staticClass:
          "w-full bg-white px-6 py-6 border-t border-blue-400 rounded overflow-scroll mb-12"
      },
      [
        _c("div", { staticClass: "text-lg text-gray-800 pb-2" }, [
          _vm._v("Edit Template Files")
        ]),
        _vm._v(" "),
        _vm._m(0),
        _vm._v(" "),
        _c("table", { staticClass: "table-auto w-full text-xs mb-2" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.files, function(file) {
              return _c("tr", [
                _c("td", { staticClass: "pr-2 py-2 border-b" }, [
                  _vm._v(
                    "\n                        " +
                      _vm._s(file.name) +
                      "\n                    "
                  )
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "pr-2 py-2 border-b" }, [
                  _vm._v(
                    "\n                        " +
                      _vm._s(file.size) +
                      "\n                    "
                  )
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "pr-2 py-2 border-b" }, [
                  _vm._v(
                    "\n                        " +
                      _vm._s(file.updated) +
                      "\n                    "
                  )
                ])
              ])
            }),
            0
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "py-2 px-4 inline-block mt-4 border rounded cursor-pointer text-sm shado1w border-blue-400 text-blue-500",
            on: { click: _vm.addTemplateFile }
          },
          [_vm._v("Add File")]
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
            value: _vm.tab === "general",
            expression: "tab==='general'"
          }
        ],
        staticClass: "w-full bg-white border-t border-blue-400 rounded mb-12"
      },
      [
        _c("div", { staticClass: "w-full sm:flex mb-4 px-6 pt-8" }, [
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
        _c("div", { staticClass: "w-full sm:flex mb-8 px-6 py-4" }, [
          _vm._m(2),
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
        _c("div", { staticClass: "w-full sm:flex my-4 border-t px-6 py-6" }, [
          _vm._m(3),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "w-full sm:w-3/4" },
            _vm._l(_vm.parameters, function(param, key) {
              return _c(
                "div",
                { staticClass: "w-full items-center border-b1 p-3" },
                [
                  _c("div", { staticClass: "w-full" }, [
                    _c("code", { staticClass: "text-gray-700 p-2 rounded" }, [
                      _vm._v(_vm._s(param.name))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "w-full my-2" }, [
                    param.type === "text"
                      ? _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: param.value,
                              expression: "param.value"
                            }
                          ],
                          staticClass:
                            "w-full max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none",
                          attrs: { type: "text" },
                          domProps: { value: param.value },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(param, "value", $event.target.value)
                            }
                          }
                        })
                      : _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: param.value,
                                expression: "param.value"
                              }
                            ],
                            staticClass:
                              "w-full max-w-lg px-2 py-1 my-1 rounded appearance-none bg-gray-200 focus:bg-white border focus:outline-none",
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
                                _vm.$set(
                                  param,
                                  "value",
                                  $event.target.multiple
                                    ? $$selectedVal
                                    : $$selectedVal[0]
                                )
                              }
                            }
                          },
                          [
                            _c(
                              "option",
                              { attrs: { disabled: "", value: "" } },
                              [_vm._v("Select")]
                            ),
                            _vm._v(" "),
                            _vm._l(
                              param.options.split(",").map(function(o) {
                                return o.trim()
                              }),
                              function(option) {
                                return _c(
                                  "option",
                                  { domProps: { value: option } },
                                  [_vm._v(_vm._s(option))]
                                )
                              }
                            )
                          ],
                          2
                        )
                  ])
                ]
              )
            }),
            0
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "w-full sm:flex mb-4 border-t px-6 py-6 bg-gray-100" },
          [
            _vm._m(4),
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
            value: _vm.tab === "parameters",
            expression: "tab==='parameters'"
          }
        ],
        staticClass:
          "w-full bg-white px-6 py-6 border-t border-blue-400 rounded overflow-scroll mb-12"
      },
      [
        _c("div", { staticClass: "text-lg text-gray-800 pb-2" }, [
          _vm._v("Create or Edit Template Parameters")
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "text-sm text-gray-800 pb-4" }, [
          _vm._v(
            "\n            Template parameters can be used to avoid hard-coding certain values in the template and replace them with parameters.\n        "
          )
        ]),
        _vm._v(" "),
        _c("table", { staticClass: "table-auto w-full text-xs mb-2" }, [
          _vm._m(5),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.parameters, function(row) {
              return _c("tr", [
                _c("td", { staticClass: "pr-2 py-2 border-b" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: row.name,
                        expression: "row.name"
                      }
                    ],
                    staticClass: "font-mono rounded w-full bg-gray-200 p-2",
                    attrs: {
                      type: "text",
                      title: "Only lowercase letters",
                      pattern: "^[a-z]+(?:_+[a-z]+)*$"
                    },
                    domProps: { value: row.name },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(row, "name", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "pr-2 py-2 border-b" }, [
                  _c(
                    "select",
                    {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.type,
                          expression: "row.type"
                        }
                      ],
                      staticClass: "text-gray-800 w-full",
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
                          _vm.$set(
                            row,
                            "type",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        }
                      }
                    },
                    [
                      _c("option", { attrs: { value: "text" } }, [
                        _vm._v("Text")
                      ]),
                      _vm._v(" "),
                      _c("option", { attrs: { value: "list" } }, [
                        _vm._v("List")
                      ])
                    ]
                  )
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "pr-2 py-2 border-b" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: row.type === "list",
                        expression: "row.type==='list'"
                      },
                      {
                        name: "model",
                        rawName: "v-model",
                        value: row.options,
                        expression: "row.options"
                      }
                    ],
                    staticClass: "font-mono rounded w-full bg-gray-200 p-2",
                    attrs: { type: "text" },
                    domProps: { value: row.options },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(row, "options", $event.target.value)
                      }
                    }
                  })
                ])
              ])
            }),
            0
          )
        ]),
        _vm._v(" "),
        _c("p", { staticClass: "text-xs font-normal" }, [
          _vm._v("No space is allowed in parameter name.")
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "py-2 px-4 inline-block mt-4 border rounded cursor-pointer text-sm shado1w border-blue-400 text-blue-500",
            on: { click: _vm.addTemplateFile }
          },
          [_vm._v("Add Parameter")]
        )
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "text-sm text-gray-800 pb-4" }, [
      _vm._v(
        "\n            You can edit or add new files for this template.\n            Template files support "
      ),
      _c("code", [_vm._v("blade")]),
      _vm._v(" syntax.\n        ")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "pr-2 py-2 border-b text-left" }, [
          _c("p", [_vm._v("File")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "hidden md:pr-2 py-2 border-b text-left" }, [
          _vm._v("Size")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "pr-2 py-2 border-b text-left" }, [
          _vm._v("Updated")
        ])
      ])
    ])
  },
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
      _c("label", { attrs: { for: "templateUrl" } }, [
        _vm._v("Set Parameters")
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "text-xs text-gray-600 py-2" }, [
        _vm._v("Provide the values for all the below paramters.")
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
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "pr-2 py-2 border-b text-left" }, [
          _c("p", [_vm._v("Parameter")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "pr-2 py-2 border-b text-left" }, [
          _vm._v("Type")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "pr-2 py-2 border-b text-left" }, [
          _vm._v("List Items")
        ])
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