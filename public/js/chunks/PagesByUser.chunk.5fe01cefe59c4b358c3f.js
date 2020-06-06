(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["PagesByUser"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Paginator.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Paginator.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    pageData: {
      type: Object,
      "default": function _default() {}
    },
    hideNavIfNoNeed: {
      type: Boolean,
      "default": true
    },
    containerClass: {
      type: String,
      "default": 'w-full md:flex md:flex-wrap md:items-center md:justify-between'
    },
    itemClass: {
      type: String,
      "default": 'w-full md:w-1/2 p-4'
    },
    navClass: {
      type: String,
      "default": 'w-full mt-4 p-4 flex justify-between items-center'
    },
    arrowClass: {
      type: String,
      "default": 'stroke-current text-gray-500 inline-block h-8 w-8 hover:text-blue-400 cursor-pointer'
    }
  },
  methods: {
    backPage: function backPage() {
      this.$emit('previous', this.pageData.prev_page_url);
    },
    nextPage: function nextPage() {
      this.$emit('next', this.pageData.next_page_url);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PageTile.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/pages/PageTile.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    page: {
      type: Object
    }
  },
  methods: {
    navigateTo: function navigateTo(url) {
      window.location.href = url;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PagesByUser.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/pages/PagesByUser.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageTile_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageTile.vue */ "./resources/js/frontend/pages/PageTile.vue");
/* harmony import */ var _components_Paginator_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/Paginator.vue */ "./resources/js/components/Paginator.vue");
/* harmony import */ var _helpers_tensor_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../helpers/tensor.js */ "./resources/js/frontend/helpers/tensor.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'pages-by-user',
  props: {
    user: {
      type: Object
    }
  },
  data: function data() {
    return {
      userPagesData: {}
    };
  },
  components: {
    Paginator: _components_Paginator_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    PageTile: _PageTile_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  created: function created() {
    this.loadUserPages();
  },
  methods: {
    loadUserPages: function loadUserPages(url) {
      var _this = this;

      url = typeof url === 'undefined' ? '/api/profiles/' + this.user.public_id + '/pages' : url;
      _helpers_tensor_js__WEBPACK_IMPORTED_MODULE_2__["xget"](url, function (response) {
        return _this.userPagesData = response;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Paginator.vue?vue&type=template&id=59656db6&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Paginator.vue?vue&type=template&id=59656db6& ***!
  \************************************************************************************************************************************************************************************************************/
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
    _c(
      "div",
      { class: _vm.containerClass },
      _vm._l(_vm.pageData.data, function(item) {
        return _c(
          "div",
          { key: item.id, class: _vm.itemClass },
          [_vm._t("default", null, { item: item })],
          2
        )
      }),
      0
    ),
    _vm._v(" "),
    (_vm.hideNavIfNoNeed && _vm.pageData.from === _vm.pageData.last_page
    ? false
    : true)
      ? _c("div", { class: _vm.navClass }, [
          _vm.pageData.prev_page_url != null
            ? _c(
                "div",
                { staticClass: "text-center", on: { click: _vm.backPage } },
                [
                  _c(
                    "svg",
                    {
                      class: _vm.arrowClass,
                      attrs: {
                        xmlns: "http://www.w3.org/2000/svg",
                        width: "36",
                        height: "36",
                        viewBox: "0 0 24 24",
                        fill: "none",
                        stroke: "currentColor",
                        "stroke-width": "1.5",
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round"
                      }
                    },
                    [
                      _c("circle", { attrs: { cx: "12", cy: "12", r: "10" } }),
                      _c("polyline", { attrs: { points: "12 8 8 12 12 16" } }),
                      _c("line", {
                        attrs: { x1: "16", y1: "12", x2: "8", y2: "12" }
                      })
                    ]
                  )
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _c("div", { staticClass: "text-center flex-grow" }, [
            _vm._v(
              "\n            " +
                _vm._s(_vm.pageData.current_page) +
                " of " +
                _vm._s(_vm.pageData.last_page) +
                "\n        "
            )
          ]),
          _vm._v(" "),
          _vm.pageData.next_page_url != null
            ? _c(
                "div",
                { staticClass: "text-center", on: { click: _vm.nextPage } },
                [
                  _c(
                    "svg",
                    {
                      class: _vm.arrowClass,
                      attrs: {
                        xmlns: "http://www.w3.org/2000/svg",
                        width: "36",
                        height: "36",
                        viewBox: "0 0 24 24",
                        fill: "none",
                        stroke: "currentColor",
                        "stroke-width": "1.5",
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round"
                      }
                    },
                    [
                      _c("circle", { attrs: { cx: "12", cy: "12", r: "10" } }),
                      _c("polyline", { attrs: { points: "12 16 16 12 12 8" } }),
                      _c("line", {
                        attrs: { x1: "8", y1: "12", x2: "16", y2: "12" }
                      })
                    ]
                  )
                ]
              )
            : _vm._e()
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PageTile.vue?vue&type=template&id=17be40f7&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/pages/PageTile.vue?vue&type=template&id=17be40f7& ***!
  \***************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "w-full p-3" }, [
    _c(
      "div",
      {
        staticClass:
          "text-2xl text-blue-600 py-3 cursor-pointer hover:text-blue-800",
        on: {
          click: function($event) {
            return _vm.navigateTo(_vm.page.url)
          }
        }
      },
      [_vm._v("\n        " + _vm._s(_vm.page.title) + "\n    ")]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "w-full" }, [
      _vm.page.media != null
        ? _c("img", {
            staticClass: "w-full object-cover",
            staticStyle: { "max-height": "12rem" },
            attrs: { src: _vm.page.media.url }
          })
        : _c("img", {
            staticClass: "w-full object-cover",
            staticStyle: { "max-height": "12rem" },
            attrs: { src: "https://source.unsplash.com/random/400x300" }
          })
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "w-full py-3" }, [
      _c("div", { staticClass: "text-gray-600" }, [
        _vm._v(_vm._s(_vm.page.summary))
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "py-3 text-blue-600 cursor-pointer hover:text-blue-800",
        on: {
          click: function($event) {
            return _vm.navigateTo(_vm.page.url)
          }
        }
      },
      [_vm._v("\n        Read More...\n    ")]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PagesByUser.vue?vue&type=template&id=03bc5efc&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/frontend/pages/PagesByUser.vue?vue&type=template&id=03bc5efc& ***!
  \******************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "my-4" }, [
    _c("div", { staticClass: "px-12 pt-3 text-xl uppercase text-gray-700" }, [
      _vm._v("\n        Pages Created by " + _vm._s(_vm.user.name) + "\n    ")
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "rounded-lg -mt-4" },
      [
        _c("Paginator", {
          attrs: {
            "page-data": _vm.userPagesData,
            "container-class":
              "w-full px-6 md:flex md:flex-wrap md:items-start md:justify-between",
            "nav-class":
              "w-full mt-4 p-4 flex justify-between items-center bg-gray-100"
          },
          on: { next: _vm.loadUserPages, previous: _vm.loadUserPages },
          scopedSlots: _vm._u([
            {
              key: "default",
              fn: function(data) {
                return [_c("PageTile", { attrs: { page: data.item } })]
              }
            }
          ])
        })
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Paginator.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/Paginator.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Paginator_vue_vue_type_template_id_59656db6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Paginator.vue?vue&type=template&id=59656db6& */ "./resources/js/components/Paginator.vue?vue&type=template&id=59656db6&");
/* harmony import */ var _Paginator_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Paginator.vue?vue&type=script&lang=js& */ "./resources/js/components/Paginator.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Paginator_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Paginator_vue_vue_type_template_id_59656db6___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Paginator_vue_vue_type_template_id_59656db6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Paginator.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Paginator.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/components/Paginator.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Paginator_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Paginator.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Paginator.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Paginator_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Paginator.vue?vue&type=template&id=59656db6&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/Paginator.vue?vue&type=template&id=59656db6& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Paginator_vue_vue_type_template_id_59656db6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Paginator.vue?vue&type=template&id=59656db6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Paginator.vue?vue&type=template&id=59656db6&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Paginator_vue_vue_type_template_id_59656db6___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Paginator_vue_vue_type_template_id_59656db6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/frontend/pages/PageTile.vue":
/*!**************************************************!*\
  !*** ./resources/js/frontend/pages/PageTile.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PageTile_vue_vue_type_template_id_17be40f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageTile.vue?vue&type=template&id=17be40f7& */ "./resources/js/frontend/pages/PageTile.vue?vue&type=template&id=17be40f7&");
/* harmony import */ var _PageTile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageTile.vue?vue&type=script&lang=js& */ "./resources/js/frontend/pages/PageTile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PageTile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PageTile_vue_vue_type_template_id_17be40f7___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PageTile_vue_vue_type_template_id_17be40f7___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/frontend/pages/PageTile.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/frontend/pages/PageTile.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/frontend/pages/PageTile.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageTile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./PageTile.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PageTile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PageTile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/frontend/pages/PageTile.vue?vue&type=template&id=17be40f7&":
/*!*********************************************************************************!*\
  !*** ./resources/js/frontend/pages/PageTile.vue?vue&type=template&id=17be40f7& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageTile_vue_vue_type_template_id_17be40f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./PageTile.vue?vue&type=template&id=17be40f7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PageTile.vue?vue&type=template&id=17be40f7&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageTile_vue_vue_type_template_id_17be40f7___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PageTile_vue_vue_type_template_id_17be40f7___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/frontend/pages/PagesByUser.vue":
/*!*****************************************************!*\
  !*** ./resources/js/frontend/pages/PagesByUser.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _PagesByUser_vue_vue_type_template_id_03bc5efc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PagesByUser.vue?vue&type=template&id=03bc5efc& */ "./resources/js/frontend/pages/PagesByUser.vue?vue&type=template&id=03bc5efc&");
/* harmony import */ var _PagesByUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PagesByUser.vue?vue&type=script&lang=js& */ "./resources/js/frontend/pages/PagesByUser.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _PagesByUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _PagesByUser_vue_vue_type_template_id_03bc5efc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _PagesByUser_vue_vue_type_template_id_03bc5efc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/frontend/pages/PagesByUser.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/frontend/pages/PagesByUser.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/frontend/pages/PagesByUser.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PagesByUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./PagesByUser.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PagesByUser.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PagesByUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/frontend/pages/PagesByUser.vue?vue&type=template&id=03bc5efc&":
/*!************************************************************************************!*\
  !*** ./resources/js/frontend/pages/PagesByUser.vue?vue&type=template&id=03bc5efc& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PagesByUser_vue_vue_type_template_id_03bc5efc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./PagesByUser.vue?vue&type=template&id=03bc5efc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/frontend/pages/PagesByUser.vue?vue&type=template&id=03bc5efc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PagesByUser_vue_vue_type_template_id_03bc5efc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PagesByUser_vue_vue_type_template_id_03bc5efc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);