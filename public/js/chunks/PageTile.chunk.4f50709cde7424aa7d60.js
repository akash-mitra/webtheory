(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["PageTile"],{

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



/***/ })

}]);