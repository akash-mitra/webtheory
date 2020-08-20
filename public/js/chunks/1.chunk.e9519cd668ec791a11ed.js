(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Page.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Page.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    page: {
      type: Object
    }
  },
  data: function data() {
    return {
      selected: null
    };
  },
  computed: {
    canChangeOwner: function canChangeOwner() {
      return ['admin', 'author'].indexOf(this.$root.authUser.role) > -1 && this.$root.authUser.id != this.page.author.id && this.page.deleted_at === null;
    }
  },
  methods: {
    // open a specific page in editor
    openPageInEditor: function openPageInEditor(page) {
      this.$router.push({
        path: '/app/pages/' + page.id
      });
    },
    openPageInNewWindow: function openPageInNewWindow(page) {
      window.open(page.url, '_blank');
    },
    // change the status (Draft / Live) of a specific page
    changePageStatus: function changePageStatus(page, status) {
      util.ajax('put', '/api/pages/' + page.id + '/status', {
        status: status
      }, function (response) {
        page.status = status;
        util.toast({
          icon: 'success',
          titleText: 'Status Updated',
          text: ' Page in ' + status + ' mode now.'
        });
      });
    },
    changeOwner: function changeOwner() {
      var _this = this;

      util.ajax('put', '/api/pages/' + this.page.id + '/owner', {
        user_id: this.$root.authUser.id
      }, function (response) {
        _this.page.author = response.author;
        util.toast({
          icon: 'success',
          titleText: 'Owner Updated',
          text: 'Page author is ' + response.author.name + ' now.'
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pages.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Pages.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Page_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Page.vue */ "./resources/js/components/Page.vue");
/* harmony import */ var _Paginator_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Paginator.vue */ "./resources/js/components/Paginator.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      paginatedPages: {},
      tab: 'all',
      searchPhrase: '',
      searchStatus: '',
      isLoading: true
    };
  },
  created: function created() {
    this.fetchFromServer();
  },
  components: {
    Page: _Page_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    Paginator: _Paginator_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  methods: {
    fetchFromServer: function fetchFromServer(url) {
      var _this = this;

      if (typeof url === 'undefined') {
        url = '/api/pages';
      }

      var oUrl = new URL(url, location.href);

      if (this.tab === 'draft') {
        oUrl.searchParams.set('type', 'draft');
      }

      oUrl.searchParams.set('query', this.searchPhrase);
      this.isLoading = true;
      util.ajax('get', oUrl, {}, function (response) {
        _this.paginatedPages = response;
        _this.searchStatus = '';
        _this.isLoading = false;
      });
    },
    doDelayedSearch: function doDelayedSearch(evt) {
      var _this2 = this;

      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;

      if (charCode === 13 || charCode === 17 || charCode === 18 || charCode === 20 || charCode === 27 || charCode === 37 || charCode === 38 || charCode === 39 || charCode === 40) {
        return;
      }

      this.searchStatus = 'Searching...';

      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }

      this.doInstantLocalSearch();
      this.timer = setTimeout(function () {
        return _this2.fetchFromServer();
      }, 500);
    },
    doInstantLocalSearch: function doInstantLocalSearch() {
      var needle = this.searchPhrase.toLowerCase();

      for (var i = 0; i < this.paginatedPages.data.length; i++) {
        var p = this.paginatedPages.data[i];

        if (p.title.toLowerCase().indexOf(needle) === -1 && p.summary.toLowerCase().indexOf(needle) === -1 && p.author.name.toLowerCase().indexOf(needle) === -1) {
          this.paginatedPages.data.splice(i, 1);
        }
      }
    },
    filterByTab: function filterByTab(tab) {
      this.tab = tab;
      this.fetchFromServer();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Page.vue?vue&type=template&id=524c0c0c&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Page.vue?vue&type=template&id=524c0c0c& ***!
  \*******************************************************************************************************************************************************************************************************/
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
      staticClass:
        "w-full bg-white shadow border-t border-blue-300 rounded my-4"
    },
    [
      _c(
        "div",
        { staticClass: "w-full relative" },
        [
          _c("t-toggle", {
            staticClass: "absolute top-0 mt-4 right-0 mr-8",
            attrs: {
              id: "change-status-page-" + _vm.page.id,
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
            on: {
              input: function($event) {
                return _vm.changePageStatus(_vm.page, _vm.page.status)
              }
            },
            model: {
              value: _vm.page.status,
              callback: function($$v) {
                _vm.$set(_vm.page, "status", $$v)
              },
              expression: "page.status"
            }
          }),
          _vm._v(" "),
          _c("h3", { staticClass: "px-6 pt-4 text-blue-400 text-sm" }, [
            _vm._v(
              "\n            " +
                _vm._s(_vm.page.category ? _vm.page.category.name : "") +
                "\n        "
            )
          ]),
          _vm._v(" "),
          _c(
            "h3",
            {
              staticClass:
                "px-6 pt-2 text-blue-800 font-semibold cursor-pointer",
              attrs: { id: "show-page-" + _vm.page.id },
              on: {
                click: function($event) {
                  return _vm.openPageInEditor(_vm.page)
                }
              }
            },
            [_vm._v("\n            " + _vm._s(_vm.page.title) + "\n        ")]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "px-6 py-4 text-sm text-gray-700" }, [
            _vm._v(_vm._s(_vm.page.summary))
          ])
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "px-6 py-2 bg-gray-100 text-xs flex justify-between items-center"
        },
        [
          _c("div", { staticClass: "mr-4 text-gray-700 flex items-center" }, [
            _c("img", {
              staticClass: "h-6 w-6 rounded-full mr-4",
              attrs: { src: _vm.page.author.avatar }
            }),
            _vm._v(
              "\n            " +
                _vm._s(_vm.page.author.name) +
                " updated " +
                _vm._s(_vm.page.updated_ago) +
                ".\n            "
            ),
            _vm.canChangeOwner
              ? _c(
                  "span",
                  {
                    staticClass:
                      "ml-4 hover:underline text-blue-400 cursor-pointer",
                    on: { click: _vm.changeOwner }
                  },
                  [_vm._v("\n                Make me Author\n            ")]
                )
              : _vm._e()
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "text-right text-normal text-gray-500 hover:text-blue-700 cursor-pointer",
              attrs: { id: "view-page-" + _vm.page.id },
              on: {
                click: function($event) {
                  return _vm.openPageInNewWindow(_vm.page)
                }
              }
            },
            [_vm._v("\n            # " + _vm._s(_vm.page.id) + "\n        ")]
          )
        ]
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pages.vue?vue&type=template&id=0810e669&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Pages.vue?vue&type=template&id=0810e669& ***!
  \********************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "max-w-4xl mx-auto mb-12" }, [
    _c(
      "div",
      { staticClass: "px-6 my-6 w-full flex justify-between items-center" },
      [
        _c(
          "h2",
          { staticClass: "text-indigo-600 text-2xl flex items-center" },
          [
            _c(
              "svg",
              {
                staticClass: "w-8 h-8 mr-3",
                attrs: {
                  xmlns: "http://www.w3.org/2000/svg",
                  viewBox: "0 0 24 24",
                  fill: "none",
                  stroke: "currentColor",
                  "stroke-width": "1.5",
                  "stroke-linecap": "round",
                  "stroke-linejoin": "round"
                }
              },
              [
                _c("path", {
                  attrs: {
                    d:
                      "M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"
                  }
                }),
                _vm._v(" "),
                _c("polyline", { attrs: { points: "13 2 13 9 20 9" } })
              ]
            ),
            _vm._v("\n            Pages\n        ")
          ]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass:
              "bg-blue-600 h-10 text-white text-sm px-4 py-2 rounded shadow",
            attrs: { href: "/app/pages/create" }
          },
          [_vm._v("Create")]
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "px-6 relative" }, [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.searchPhrase,
            expression: "searchPhrase"
          }
        ],
        staticClass:
          "w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none",
        attrs: {
          type: "text",
          name: "search",
          placeholder: "Search by page title, category or author..."
        },
        domProps: { value: _vm.searchPhrase },
        on: {
          keyup: _vm.doDelayedSearch,
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.searchPhrase = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c(
        "span",
        {
          staticClass:
            "absolute inset-y-0 right-0 pr-12 flex items-center text-gray-700"
        },
        [_vm._v("\n            " + _vm._s(_vm.searchStatus) + "\n        ")]
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "px-6 w-full flex justify-start items-center my-8 border-b"
      },
      [
        _c(
          "div",
          {
            staticClass: "px-4 text-sm uppercase cursor-pointer",
            class:
              _vm.tab === "all"
                ? "text-gray-700 py-2 border-b-4 border-blue-500"
                : "text-gray-500 py-2",
            attrs: { id: "all-tab" },
            on: {
              click: function($event) {
                return _vm.filterByTab("all")
              }
            }
          },
          [_vm._v("\n            All\n        ")]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "px-4 text-sm uppercase cursor-pointer",
            class:
              _vm.tab === "draft"
                ? "text-gray-700 py-2 border-b-4 border-blue-500"
                : "text-gray-500 py-2",
            attrs: { id: "draft-tab" },
            on: {
              click: function($event) {
                return _vm.filterByTab("draft")
              }
            }
          },
          [_vm._v("\n            Draft\n        ")]
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "px-6" },
      [
        _vm._l(Array(3).keys(), function(i) {
          return _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.isLoading,
                  expression: "isLoading"
                }
              ],
              staticClass:
                "w-full bg-white mt-6 shadow border-t border-blue-400"
            },
            [
              _vm._m(0, true),
              _vm._v(" "),
              _vm._m(1, true),
              _vm._v(" "),
              _vm._m(2, true),
              _vm._v(" "),
              _vm._m(3, true),
              _vm._v(" "),
              _c("div", { staticClass: "mt-3 bg-gray-100 h-8" })
            ]
          )
        }),
        _vm._v(" "),
        _c("Paginator", {
          attrs: {
            "page-data": _vm.paginatedPages,
            "container-class": "w-full",
            "item-class": "w-full",
            "nav-class":
              "w-full p-4 flex justify-between items-center bg-gray-100"
          },
          on: { next: _vm.fetchFromServer, previous: _vm.fetchFromServer },
          scopedSlots: _vm._u([
            {
              key: "default",
              fn: function(data) {
                return [_c("Page", { attrs: { page: data.item } })]
              }
            }
          ])
        }),
        _vm._v(" "),
        _c("span", { staticClass: "text-sm text-gray-700" }, [
          _vm._v(_vm._s(_vm.searchStatus))
        ])
      ],
      2
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "px-6 flex justify-between" }, [
      _c("span", { staticClass: "bg-blue-100 text-blue-100 mt-4" }, [
        _vm._v("Category Name")
      ]),
      _vm._v(" "),
      _c("span", { staticClass: "bg-gray-200 text-gray-200 mt-3" }, [
        _vm._v("Draft View")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "px-6 mt-3" }, [
      _c("span", { staticClass: "bg-blue-200 text-blue-200" }, [
        _vm._v(
          "\n                    Lorem ipsum dolor sit amet consectetur\n                "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "px-6 mt-3" }, [
      _c("span", { staticClass: "bg-gray-200 text-gray-200" }, [
        _vm._v(
          "\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit excepturi\n                    assumenda dolore asperiores\n                "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "px-6 mt-1" }, [
      _c("span", { staticClass: "bg-gray-200 text-gray-200" }, [
        _vm._v(
          "\n                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, deserunt!\n                "
        )
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Page.vue":
/*!******************************************!*\
  !*** ./resources/js/components/Page.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Page_vue_vue_type_template_id_524c0c0c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Page.vue?vue&type=template&id=524c0c0c& */ "./resources/js/components/Page.vue?vue&type=template&id=524c0c0c&");
/* harmony import */ var _Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Page.vue?vue&type=script&lang=js& */ "./resources/js/components/Page.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Page_vue_vue_type_template_id_524c0c0c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Page_vue_vue_type_template_id_524c0c0c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Page.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Page.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/components/Page.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Page.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Page.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Page.vue?vue&type=template&id=524c0c0c&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Page.vue?vue&type=template&id=524c0c0c& ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_524c0c0c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Page.vue?vue&type=template&id=524c0c0c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Page.vue?vue&type=template&id=524c0c0c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_524c0c0c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_524c0c0c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Pages.vue":
/*!*******************************************!*\
  !*** ./resources/js/components/Pages.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Pages_vue_vue_type_template_id_0810e669___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Pages.vue?vue&type=template&id=0810e669& */ "./resources/js/components/Pages.vue?vue&type=template&id=0810e669&");
/* harmony import */ var _Pages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Pages.vue?vue&type=script&lang=js& */ "./resources/js/components/Pages.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Pages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Pages_vue_vue_type_template_id_0810e669___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Pages_vue_vue_type_template_id_0810e669___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Pages.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Pages.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/components/Pages.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Pages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Pages.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pages.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Pages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Pages.vue?vue&type=template&id=0810e669&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/Pages.vue?vue&type=template&id=0810e669& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Pages_vue_vue_type_template_id_0810e669___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Pages.vue?vue&type=template&id=0810e669& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Pages.vue?vue&type=template&id=0810e669&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Pages_vue_vue_type_template_id_0810e669___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Pages_vue_vue_type_template_id_0810e669___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);