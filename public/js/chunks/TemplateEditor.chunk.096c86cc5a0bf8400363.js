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
var render = function () {}
var staticRenderFns = []



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