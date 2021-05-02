/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _helpers_tensor_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/tensor.js */ "./resources/js/frontend/helpers/tensor.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    content_type: {
      required: true,
      type: String
    },
    refid: {
      required: true,
      type: String
    },
    captcha_site_key: {
      required: true,
      type: String
    },
    boxClass: {
      type: String,
      "default": 'w-full flex p-4 rounded-lg mb-2 pb-6 bg-gray-100 border'
    },
    textBoxClass: {
      type: String,
      "default": 'mt-2 rounded-lg p-2 w-full h-12 border-2'
    },
    buttonClass: {
      type: String,
      "default": 'ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800'
    },
    linkClass: {
      type: String,
      "default": 'font-bold text-blue-800'
    },
    commentClass: {
      type: String,
      "default": 'text-gray-800'
    },
    textClass: {
      type: String,
      "default": 'text-gray-800'
    },
    replyTextClass: {
      type: String,
      "default": 'hover:text-orange-500'
    },
    commentInviteClass: {
      type: String,
      "default": 'w-full flex p-4 border rounded-lg mb-4 justify-between items-center'
    }
  },
  data: function data() {
    return {
      comments: {},
      comment: '',
      replyText: '',
      unsavedComment: {},
      authUser: false,
      networkActionInProgress: false,
      reply: null,
      commentOrReply: '',
      wt_recaptcha_token: ''
    };
  },
  mounted: function mounted() {},
  created: function created() {
    var _this = this;

    this.authUser = this.$root.$data.authuser;
    this.loadInitialComments();
    grecaptcha.ready(function () {
      grecaptcha.render(_this.$refs.recaptcha, {
        'sitekey': _this.captcha_site_key,
        'size': 'invisible'
      });
    });
  },
  methods: {
    loadInitialComments: function loadInitialComments() {
      var p = this;
      _helpers_tensor_js__WEBPACK_IMPORTED_MODULE_0__.xget(this.getUrl(), function (response) {
        p.comments = response;
      });
    },
    loadMoreComments: function loadMoreComments() {
      var p = this;
      _helpers_tensor_js__WEBPACK_IMPORTED_MODULE_0__.xget(this.getUrl(), function (response) {
        var l = response.data.length;

        for (var i = 0; i < l; i++) {
          p.comments.data.push(response.data[i]);
        }

        p.comments.next_page_url = response.next_page_url;
      });
    },
    postComment: function postComment() {
      var $this = this;
      grecaptcha.ready(function () {
        grecaptcha.execute(this.captcha_site_key, {
          action: 'postComment'
        }).then(function (token) {
          $this.networkActionInProgress = true;
          var c = {
            body: $this.comment,
            created_ago: 'just now',
            replies: [],
            user: $this.authUser,
            wt_recaptcha_token: token
          },
              p = $this;
          _helpers_tensor_js__WEBPACK_IMPORTED_MODULE_0__.xpost($this.postUrl(), c, function (response) {
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
        });
      });
    },
    postReply: function postReply(reply) {
      var $this = this;
      grecaptcha.ready(function () {
        grecaptcha.execute(this.captcha_site_key, {
          action: 'postReply'
        }).then(function (token) {
          $this.networkActionInProgress = true;
          var p = $this;
          _helpers_tensor_js__WEBPACK_IMPORTED_MODULE_0__.xpost($this.postUrl(), {
            body: $this.replyText,
            parent_id: reply.parent_id,
            wt_recaptcha_token: token
          }, function () {
            reply.body = p.replyText;
            p.replyText = '';
            p.networkActionInProgress = false;
          });
        });
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

/***/ "./resources/js/frontend/helpers/tensor.js":
/*!*************************************************!*\
  !*** ./resources/js/frontend/helpers/tensor.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "xget": () => (/* binding */ xget),
/* harmony export */   "xpost": () => (/* binding */ xpost),
/* harmony export */   "xput": () => (/* binding */ xput),
/* harmony export */   "xpatch": () => (/* binding */ xpatch),
/* harmony export */   "xhttp": () => (/* binding */ xhttp)
/* harmony export */ });
function xget(url, handler, error) {
  return xhttp(url, {}, handler, error, 'GET');
}
function xpost(url, data, handler, error) {
  return xhttp(url, data, handler, error, 'POST');
}
function xput(url, data, handler, error) {
  return xhttp(url, data, handler, error, 'PUT');
}
function xpatch(url, data, handler, error) {
  return xhttp(url, data, handler, error, 'PATCH');
}
function xhttp(url, data, handler, error, method) {
  var xhr = new XMLHttpRequest();

  xhr.onload = function () {
    if (xhr.status < 200 || xhr.status >= 300) {
      !!error && error(xhr.response, xhr.status);
    } else {
      !!handler && handler(xhr.response, xhr.status);
    }
  };

  xhr.onerror = function () {
    console.log('Network Error');
  };

  xhr.open(method, url, true);
  xhr.responseType = 'json';
  xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
  xhr.setRequestHeader('Accept', 'application/json');
  data['_token'] = window.csrf_token;
  xhr.send(JSON.stringify(data));
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.comment-strip-style[data-v-4052262a] {\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {

"use strict";


/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue":
/*!****************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Comments.vue?vue&type=template&id=4052262a&scoped=true& */ "./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&");
/* harmony import */ var _Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Comments.vue?vue&type=script&lang=js& */ "./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&");
/* harmony import */ var _Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& */ "./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "4052262a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/frontend/modules/Comments.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Comments.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_template_id_4052262a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Comments.vue?vue&type=template&id=4052262a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&");


/***/ }),

/***/ "./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_style_loader_index_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-style-loader/index.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& */ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_style_loader_index_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vue_style_loader_index_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(const __WEBPACK_IMPORT_KEY__ in _node_modules_vue_style_loader_index_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== "default") __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = () => _node_modules_vue_style_loader_index_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Comments_vue_vue_type_style_index_0_id_4052262a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[__WEBPACK_IMPORT_KEY__]
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=template&id=4052262a&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { ref: "recaptcha" }),
    _vm._v(" "),
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
          ? _c("div", { class: _vm.boxClass }, [
              _c("a", { attrs: { href: _vm.authUser.url } }, [
                _c("img", {
                  staticClass: "h-12 w-12 rounded-full",
                  attrs: { src: _vm.authUser.avatar }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "w-full text-sm px-4" }, [
                _c("div", [
                  _c("span", { class: _vm.linkClass }, [
                    _vm._v(_vm._s(_vm.authUser.name))
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "ml-3", class: _vm.textClass }, [
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
                    class: _vm.textBoxClass,
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
                          expression: "comment.length > 0"
                        }
                      ],
                      staticClass: "w-full flex justify-end items-center mt-2"
                    },
                    [
                      _c("div", [
                        _c("span", { class: _vm.textClass }, [
                          _vm._v(_vm._s(_vm.comment.length) + " characters")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          class: _vm.buttonClass,
                          attrs: { disabled: _vm.networkActionInProgress },
                          on: { click: _vm.postComment }
                        },
                        [
                          _vm._v(
                            "\n                            Post\n                        "
                          )
                        ]
                      )
                    ]
                  )
                ])
              ])
            ])
          : _c("div", { class: _vm.commentInviteClass }, [
              _c("div", [_vm._v("Join the Discussion.")]),
              _vm._v(" "),
              _c(
                "div",
                {
                  class: _vm.buttonClass,
                  on: {
                    click: function($event) {
                      $event.stopPropagation()
                      return _vm.showLoginOption($event)
                    }
                  }
                },
                [_vm._v("\n                Sign Up / Login\n            ")]
              )
            ]),
        _vm._v(" "),
        _vm._l(_vm.comments.data, function(comment) {
          return _c("div", { staticClass: "w-full flex p-4" }, [
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
                  _c("span", { class: _vm.linkClass }, [
                    _vm._v(_vm._s(comment.user.name))
                  ]),
                  _vm._v(" "),
                  _c("span", { class: _vm.textClass }, [
                    _vm._v("commented " + _vm._s(comment.created_ago))
                  ])
                ]),
                _vm._v(" "),
                _c("div", { class: _vm.commentClass }, [
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
                              class: _vm.replyTextClass,
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
                      ? _c("span", { class: _vm.replyTextClass }, [
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
                        _c("span", { class: _vm.linkClass }, [
                          _vm._v(_vm._s(reply.user.name))
                        ]),
                        _vm._v(" "),
                        _c("span", { class: _vm.textClass }, [
                          _vm._v("replied " + _vm._s(reply.created_ago))
                        ])
                      ]),
                      _vm._v(" "),
                      reply.body.length > 0
                        ? _c("div", { class: _vm.commentClass }, [
                            _vm._v(
                              "\n                            " +
                                _vm._s(reply.body) +
                                "\n\n                            "
                            ),
                            _c(
                              "div",
                              {
                                staticClass:
                                  "w-full flex justify-between py-1 text-xs tracking-wide"
                              },
                              [
                                _c(
                                  "div",
                                  { staticClass: "flex justify-start" },
                                  [
                                    _c(
                                      "button",
                                      {
                                        class: _vm.replyTextClass,
                                        on: {
                                          click: function($event) {
                                            return _vm.openReplyBox(
                                              reply.parent_id
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                        Reply\n                                    "
                                        )
                                      ]
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
                                      [
                                        _vm._v(
                                          "\n                                        Like\n                                    "
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ]
                            )
                          ])
                        : _c("div", [
                            _c("textarea", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.replyText,
                                  expression: "replyText"
                                }
                              ],
                              class: _vm.textBoxClass,
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
                                    expression: "replyText.length > 0"
                                  }
                                ],
                                staticClass:
                                  "w-full flex justify-end items-center mt-2"
                              },
                              [
                                _c("div", [
                                  _c("span", { class: _vm.textClass }, [
                                    _vm._v(
                                      _vm._s(_vm.replyText.length) +
                                        " characters"
                                    )
                                  ])
                                ]),
                                _vm._v(" "),
                                _c(
                                  "button",
                                  {
                                    class: _vm.buttonClass,
                                    attrs: {
                                      disabled: _vm.networkActionInProgress
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.postReply(reply)
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    Post\n                                "
                                    )
                                  ]
                                )
                              ]
                            )
                          ])
                    ])
                  ])
                })
              ],
              2
            )
          ])
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

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-style-loader/index.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/frontend/modules/Comments.vue?vue&type=style&index=0&id=4052262a&scoped=true&lang=css&");
if(content.__esModule) content = content.default;
if(typeof content === 'string') content = [[module.id, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var add = __webpack_require__(/*! !../../../../node_modules/vue-style-loader/lib/addStylesClient.js */ "./node_modules/vue-style-loader/lib/addStylesClient.js").default
var update = add("2dd3a2ba", content, false, {});
// Hot Module Replacement
if(false) {}

/***/ }),

/***/ "./node_modules/vue-style-loader/lib/addStylesClient.js":
/*!**************************************************************!*\
  !*** ./node_modules/vue-style-loader/lib/addStylesClient.js ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ addStylesClient)
/* harmony export */ });
/* harmony import */ var _listToStyles__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./listToStyles */ "./node_modules/vue-style-loader/lib/listToStyles.js");
/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/



var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

function addStylesClient (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = (0,_listToStyles__WEBPACK_IMPORTED_MODULE_0__.default)(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = (0,_listToStyles__WEBPACK_IMPORTED_MODULE_0__.default)(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ "./node_modules/vue-style-loader/lib/listToStyles.js":
/*!***********************************************************!*\
  !*** ./node_modules/vue-style-loader/lib/listToStyles.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ listToStyles)
/* harmony export */ });
/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			id: moduleId,
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***************************************************!*\
  !*** ./resources/js/frontend/modules/comments.js ***!
  \***************************************************/
Vue.component('wt-comments', __webpack_require__(/*! ./Comments.vue */ "./resources/js/frontend/modules/Comments.vue").default);
})();

/******/ })()
;