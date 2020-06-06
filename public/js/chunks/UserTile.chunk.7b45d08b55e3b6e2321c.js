(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["UserTile"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    content_type: {
      required: true,
      type: String
    },
    refid: {
      required: true,
      type: String
    }
  },
  data: function data() {
    return {
      comments: {},
      comment: '',
      replyText: '',
      unsavedComment: {},
      authUser: false,
      networkActionInProgress: false
    };
  },
  created: function created() {
    this.authUser = this.$root.$data.authuser;
    this.loadInitialComments();
  },
  methods: {
    loadInitialComments: function loadInitialComments() {
      var p = this;
      this.ajaxGet(this.getUrl(), function (response) {
        p.comments = response;
      });
    },
    loadMoreComments: function loadMoreComments() {
      var p = this;
      this.ajaxGet(this.getUrl(), function (response) {
        var l = response.data.length;

        for (var i = 0; i < l; i++) {
          p.comments.data.push(response.data[i]);
        }

        p.comments.next_page_url = response.next_page_url;
      });
    },
    postComment: function postComment() {
      this.networkActionInProgress = true;
      var c = {
        body: this.comment,
        created_ago: 'just now',
        replies: [],
        user: this.authUser
      },
          p = this;
      this.ajaxPost(this.postUrl(), c, function (response) {
        // the response contains the comment data
        // however, we must also add the "user"
        // and replies with this.
        response['user'] = c.user;
        response['replies'] = c.replies;
        p.comments.data.unshift(response);
        p.networkActionInProgress = false;
      }, function (error) {
        console.log(error);
        p.networkActionInProgress = false;
      });
    },
    postReply: function postReply(reply) {
      var p = this;
      this.networkActionInProgress = true;
      this.ajaxPost(this.postUrl(), {
        'body': this.replyText,
        'parent_id': reply.parent_id
      }, function (response) {
        reply.body = p.replyText;
        p.replyText = '';
        p.networkActionInProgress = false;
      });
    },
    openReplyBox: function openReplyBox(id) {
      var parentComment = this.comments.data.filter(function (comment) {
        return comment.id === id;
      })[0];
      parentComment.replies.unshift({
        body: '',
        parent_id: id,
        user: this.authUser
      });
    },
    ajaxGet: function ajaxGet(url, handler) {
      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function () {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
          handler(JSON.parse(xhttp.responseText));
        }
      };

      xhttp.open("GET", url, true);
      xhttp.send();
    },
    ajaxPost: function ajaxPost(url, data, handler) {
      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function () {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
          handler(JSON.parse(xhttp.responseText));
        }
      };

      xhttp.open("POST", url, true);
      xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      data["_token"] = window.csrf_token;
      xhttp.send(JSON.stringify(data));
    },
    getUrl: function getUrl() {
      var _this$comments$next_p;

      var type = this.content_type === 'single' ? 'pages' : 'categories';
      return (_this$comments$next_p = this.comments.next_page_url) !== null && _this$comments$next_p !== void 0 ? _this$comments$next_p : '/api/' + type + '/' + this.refid + '/comments';
    },
    postUrl: function postUrl() {
      var type = this.content_type === 'single' ? 'pages' : 'categories';
      return '/api/' + type + '/' + this.refid + '/comments';
    },
    showLoginOption: function showLoginOption() {
      this.$root.$data.isLoginModalOpen = true;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// Imports
var ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
exports = ___CSS_LOADER_API_IMPORT___(false);
// Module
exports.push([module.i, "\n.comment-strip-style[data-v-4052262a] {\n}\n\n", ""]);
// Exports
module.exports = exports;


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader/dist/cjs.js??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader/dist/cjs.js??ref--7-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "w-full mb-3 py-4" }, [
      _c("h4", { staticClass: "text-xl" }, [
        _vm._v(_vm._s(_vm.comments.total) + " Comments")
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      [
        !!_vm.authUser
          ? _c(
              "div",
              {
                staticClass:
                  "w-full flex p-4 bg-gray-100 border rounded-lg mb-2"
              },
              [
                _c("a", { attrs: { href: _vm.authUser.url } }, [
                  _c("img", {
                    staticClass: "h-12 w-12 rounded-full",
                    attrs: { src: _vm.authUser.avatar }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "w-full text-sm px-4" }, [
                  _c("div", [
                    _c("span", { staticClass: "text-blue-800 font-bold" }, [
                      _vm._v(_vm._s(_vm.authUser.name))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "ml-3" }, [
                      _vm._v("— Join the discussion")
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "w-full text-gray-800" }, [
                    _c("textarea", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.comment,
                          expression: "comment"
                        }
                      ],
                      staticClass: "mt-2 border-2 rounded p-2 w-full h-12",
                      attrs: { onclick: "this.classList.remove('h-12')" },
                      domProps: { value: _vm.comment },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.comment = $event.target.value
                        }
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
                            value: _vm.comment.length > 0,
                            expression: "comment.length>0"
                          }
                        ],
                        staticClass: "w-full flex justify-end items-center mt-2"
                      },
                      [
                        _c("div", [
                          _c("span", { staticClass: "text-xs text-gray-200" }, [
                            _vm._v(_vm._s(_vm.comment.length) + " characters")
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass:
                              "ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800",
                            attrs: { disabled: _vm.networkActionInProgress },
                            on: { click: _vm.postComment }
                          },
                          [_vm._v("Post")]
                        )
                      ]
                    )
                  ])
                ])
              ]
            )
          : _c(
              "div",
              {
                staticClass:
                  "w-full flex p-4 bg-gray-100 border rounded-lg mb-4 justify-between items-center"
              },
              [
                _c("div", { staticClass: "text-xl" }, [
                  _vm._v("Join the Discussion.")
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "bg-orange-600 text-white py-1 px-4 cursor-pointer rounded hover:bg-orange-800",
                    on: {
                      click: function($event) {
                        $event.stopPropagation()
                        return _vm.showLoginOption($event)
                      }
                    }
                  },
                  [_vm._v("\n                Sign Up / Login\n            ")]
                )
              ]
            ),
        _vm._v(" "),
        _vm._l(_vm.comments.data, function(comment) {
          return _c(
            "div",
            { staticClass: "w-full flex p-4 border-b border-gray-200" },
            [
              _c("a", { attrs: { href: comment.user.url } }, [
                _c("img", {
                  staticClass: "h-12 w-12 rounded-full",
                  attrs: { src: comment.user.avatar }
                })
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "w-full text-sm px-4" },
                [
                  _c("div", { staticClass: "pb-1" }, [
                    _c(
                      "span",
                      { staticClass: "text-blue-800 font-bold tracking-wide" },
                      [_vm._v(_vm._s(comment.user.name))]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "ml-1 text-gray-600" }, [
                      _vm._v("commented " + _vm._s(comment.created_ago))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "text-gray-800" }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(comment.body) +
                        "\n                "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "w-full flex justify-between py-1 text-gray-600 text-xs tracking-wide"
                    },
                    [
                      _c("div", { staticClass: "flex justify-start" }, [
                        !!_vm.authUser
                          ? _c(
                              "button",
                              {
                                staticClass: "hover:text-orange-500",
                                on: {
                                  click: function($event) {
                                    return _vm.openReplyBox(comment.id)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                            Reply\n                        "
                                )
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: false,
                                expression: "false"
                              }
                            ],
                            staticClass: "text-gray-600"
                          },
                          [_vm._v(" • ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: false,
                                expression: "false"
                              }
                            ],
                            staticClass: "hover:text-orange-500"
                          },
                          [_vm._v("Like")]
                        )
                      ]),
                      _vm._v(" "),
                      comment.replies.length > 1
                        ? _c("span", { staticClass: "hover:text-orange-500" }, [
                            _vm._v(_vm._s(comment.replies.length) + " Replies")
                          ])
                        : _vm._e()
                    ]
                  ),
                  _vm._v(" "),
                  _vm._l(comment.replies, function(reply) {
                    return _c("div", { staticClass: "w-full pt-6 flex" }, [
                      _c("a", { attrs: { href: reply.user.url } }, [
                        _c("img", {
                          staticClass: "h-12 w-12 rounded-full",
                          attrs: { src: reply.user.avatar }
                        })
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "w-full text-sm px-4" }, [
                        _c("div", { staticClass: "pb-1" }, [
                          _c(
                            "span",
                            {
                              staticClass:
                                "text-blue-800 font-semibold tracking-wide"
                            },
                            [_vm._v(_vm._s(reply.user.name))]
                          ),
                          _vm._v(" "),
                          _c("span", { staticClass: "ml-1 text-gray-600" }, [
                            _vm._v("replied " + _vm._s(reply.created_ago))
                          ])
                        ]),
                        _vm._v(" "),
                        reply.body.length > 0
                          ? _c("div", { staticClass: "text-gray-800" }, [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(reply.body) +
                                  "\n\n                            "
                              ),
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "w-full flex justify-between py-1 text-gray-600 text-xs tracking-wide"
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "flex justify-start" },
                                    [
                                      _c(
                                        "button",
                                        {
                                          staticClass: "hover:text-orange-500",
                                          on: {
                                            click: function($event) {
                                              return _vm.openReplyBox(
                                                reply.parent_id
                                              )
                                            }
                                          }
                                        },
                                        [_vm._v("Reply")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "span",
                                        {
                                          directives: [
                                            {
                                              name: "show",
                                              rawName: "v-show",
                                              value: false,
                                              expression: "false"
                                            }
                                          ],
                                          staticClass: "text-gray-600"
                                        },
                                        [_vm._v(" • ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "button",
                                        {
                                          directives: [
                                            {
                                              name: "show",
                                              rawName: "v-show",
                                              value: false,
                                              expression: "false"
                                            }
                                          ],
                                          staticClass: "hover:text-orange-500"
                                        },
                                        [_vm._v("Like")]
                                      )
                                    ]
                                  )
                                ]
                              )
                            ])
                          : _c(
                              "div",
                              {
                                staticClass: "w-full text-gray-800 bg-gray-100"
                              },
                              [
                                _c("textarea", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.replyText,
                                      expression: "replyText"
                                    }
                                  ],
                                  staticClass:
                                    "mt-2 border-2 rounded p-2 w-full h-12",
                                  attrs: {
                                    onclick: "this.classList.remove('h-12')"
                                  },
                                  domProps: { value: _vm.replyText },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.replyText = $event.target.value
                                    }
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
                                        value: _vm.replyText.length > 0,
                                        expression: "replyText.length>0"
                                      }
                                    ],
                                    staticClass:
                                      "w-full flex justify-end items-center mt-2"
                                  },
                                  [
                                    _c("div", [
                                      _c(
                                        "span",
                                        {
                                          staticClass: "text-xs text-gray-200"
                                        },
                                        [
                                          _vm._v(
                                            _vm._s(_vm.replyText.length) +
                                              " characters"
                                          )
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800",
                                        attrs: {
                                          disabled: _vm.networkActionInProgress
                                        },
                                        on: {
                                          click: function($event) {
                                            return _vm.postReply(reply)
                                          }
                                        }
                                      },
                                      [_vm._v("Post")]
                                    )
                                  ]
                                )
                              ]
                            )
                      ])
                    ])
                  })
                ],
                2
              )
            ]
          )
        })
      ],
      2
    ),
    _vm._v(" "),
    _vm.comments.next_page_url != null
      ? _c("div", { staticClass: "mt-4" }, [
          _c(
            "span",
            {
              staticClass: "px-3 py-1 cursor-pointer text-blue-700 text-sm",
              on: { click: _vm.loadMoreComments }
            },
            [_vm._v("Load more comments")]
          )
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue":
/*!****************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Comments.vue?vue&type=template&id=4052262a&scoped=true& */ "./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&");
/* harmony import */ var _Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Comments.vue?vue&type=script&lang=js& */ "./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& */ "./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "4052262a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/frontend/modules/Comments.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Comments.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& ***!
  \*************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader/dist/cjs.js??ref--7-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_dist_cjs_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Comments.vue?vue&type=template&id=4052262a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);