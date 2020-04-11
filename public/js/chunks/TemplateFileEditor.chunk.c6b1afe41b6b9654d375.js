(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["TemplateFileEditor"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateFileEditor.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TemplateFileEditor.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      templateName: 'template name',
      isSaving: false,
      sourceCode: '<html></html>',
      id: 0
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
    fetchContentAndLoadEditor: function fetchContentAndLoadEditor() {
      var _this = this;

      if (typeof this.$route.params.id != 'undefined' && parseInt(this.$route.params.id) > 0 && typeof this.$route.params.file != 'undefined') {
        util.ajax('get', '/api/templates/' + this.$route.params.id + '/get/' + this.$route.params.file, {}, function (data) {
          return _this.sourceCode = data;
        });
      }
    },
    isValid: function isValid() {
      // if (!this.type) {
      //     util.notifyError('Template must have a type', 'Select any one type for this template, e.g. "Home" or "Single" etc.')
      //     return false
      // }
      return true;
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
    deletePage: function deletePage() {}
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateFileEditor.vue?vue&type=template&id=28a22364&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TemplateFileEditor.vue?vue&type=template&id=28a22364& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
      { staticClass: "px-2 my-6 w-full flex justify-between items-baseline" },
      [
        _c("h2", { staticClass: "text-gray-600 text-2xl flex items-center" }, [
          _vm._v(_vm._s(_vm.templateName))
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
      { staticClass: "w-full rounded mb-12" },
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
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/TemplateFileEditor.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/TemplateFileEditor.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TemplateFileEditor_vue_vue_type_template_id_28a22364___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TemplateFileEditor.vue?vue&type=template&id=28a22364& */ "./resources/js/components/TemplateFileEditor.vue?vue&type=template&id=28a22364&");
/* harmony import */ var _TemplateFileEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TemplateFileEditor.vue?vue&type=script&lang=js& */ "./resources/js/components/TemplateFileEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TemplateFileEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TemplateFileEditor_vue_vue_type_template_id_28a22364___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TemplateFileEditor_vue_vue_type_template_id_28a22364___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/TemplateFileEditor.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/TemplateFileEditor.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/TemplateFileEditor.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateFileEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TemplateFileEditor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateFileEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateFileEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/TemplateFileEditor.vue?vue&type=template&id=28a22364&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/TemplateFileEditor.vue?vue&type=template&id=28a22364& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateFileEditor_vue_vue_type_template_id_28a22364___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TemplateFileEditor.vue?vue&type=template&id=28a22364& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TemplateFileEditor.vue?vue&type=template&id=28a22364&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateFileEditor_vue_vue_type_template_id_28a22364___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TemplateFileEditor_vue_vue_type_template_id_28a22364___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);