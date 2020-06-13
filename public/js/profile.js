!function(e){var t={};function r(a){if(t[a])return t[a].exports;var n=t[a]={i:a,l:!1,exports:{}};return e[a].call(n.exports,n,n.exports,r),n.l=!0,n.exports}r.m=e,r.c=t,r.d=function(e,t,a){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(r.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)r.d(a,n,function(t){return e[t]}.bind(null,n));return a},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=83)}({0:function(e,t,r){"use strict";function a(e,t,r,a,n,s,o,i){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=r,c._compiled=!0),a&&(c.functional=!0),s&&(c._scopeId="data-v-"+s),o?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(o)},c._ssrRegister=l):n&&(l=i?function(){n.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(e,t){return l.call(t),u(e,t)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:e,options:c}}r.d(t,"a",(function(){return a}))},10:function(e,t,r){"use strict";function a(e,t,r){return s(e,{},t,r,"GET")}function n(e,t,r,a){return s(e,t,r,a,"PATCH")}function s(e,t,r,a,n){var s=new XMLHttpRequest;s.onload=function(){s.status<200||s.status>=300?a&&a(s.response,s.status):r&&r(s.response,s.status)},s.onerror=function(){console.log("Network Error")},s.open(n,e,!0),s.responseType="json",s.setRequestHeader("Content-Type","application/json;charset=UTF-8"),s.setRequestHeader("Accept","application/json"),t._token=window.csrf_token,s.send(JSON.stringify(t))}r.d(t,"a",(function(){return a})),r.d(t,"b",(function(){return n}))},11:function(e,t,r){"use strict";var a={props:{pageData:{type:Object,default:function(){}},hideNavIfNoNeed:{type:Boolean,default:!0},containerClass:{type:String,default:"w-full md:flex md:flex-wrap md:items-center md:justify-between"},itemClass:{type:String,default:"w-full md:w-1/2 p-4"},navClass:{type:String,default:"w-full mt-4 p-4 flex justify-between items-center"},arrowClass:{type:String,default:"stroke-current text-blue-500 inline-block h-8 w-8 hover:text-blue-600 cursor-pointer"}},methods:{backPage:function(){this.$emit("previous",this.pageData.prev_page_url)},nextPage:function(){this.$emit("next",this.pageData.next_page_url)}}},n=r(0),s=Object(n.a)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("div",{class:e.containerClass},e._l(e.pageData.data,(function(t){return r("div",{key:t.id,class:e.itemClass},[e._t("default",null,{item:t})],2)})),0),e._v(" "),e.hideNavIfNoNeed&&e.pageData.from===e.pageData.last_page?e._e():r("div",{class:e.navClass},[null!=e.pageData.prev_page_url?r("div",{staticClass:"text-center",on:{click:e.backPage}},[r("svg",{class:e.arrowClass,attrs:{xmlns:"http://www.w3.org/2000/svg",width:"36",height:"36",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round"}},[r("circle",{attrs:{cx:"12",cy:"12",r:"10"}}),r("polyline",{attrs:{points:"12 8 8 12 12 16"}}),r("line",{attrs:{x1:"16",y1:"12",x2:"8",y2:"12"}})])]):e._e(),e._v(" "),r("div",{staticClass:"text-center flex-grow"},[e._v("\n            "+e._s(e.pageData.current_page)+" of "+e._s(e.pageData.last_page)+"\n        ")]),e._v(" "),null!=e.pageData.next_page_url?r("div",{staticClass:"text-center",on:{click:e.nextPage}},[r("svg",{class:e.arrowClass,attrs:{xmlns:"http://www.w3.org/2000/svg",width:"36",height:"36",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1.5","stroke-linecap":"round","stroke-linejoin":"round"}},[r("circle",{attrs:{cx:"12",cy:"12",r:"10"}}),r("polyline",{attrs:{points:"12 16 16 12 12 8"}}),r("line",{attrs:{x1:"8",y1:"12",x2:"16",y2:"12"}})])]):e._e()])])}),[],!1,null,null,null);t.a=s.exports},13:function(e,t){e.exports=function(e){var t="undefined"!=typeof window&&window.location;if(!t)throw new Error("fixUrls requires window.location");if(!e||"string"!=typeof e)return e;var r=t.protocol+"//"+t.host,a=r+t.pathname.replace(/\/[^\/]*$/,"/");return e.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,(function(e,t){var n,s=t.trim().replace(/^"(.*)"$/,(function(e,t){return t})).replace(/^'(.*)'$/,(function(e,t){return t}));return/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(s)?e:(n=0===s.indexOf("//")?s:0===s.indexOf("/")?r+s:a+s.replace(/^\.\//,""),"url("+JSON.stringify(n)+")")}))}},27:function(e,t,r){var a=r(86);"string"==typeof a&&(a=[[e.i,a,""]]);var n={hmr:!0,transform:void 0,insertInto:void 0};r(6)(a,n);a.locals&&(e.exports=a.locals)},28:function(e,t,r){var a=r(88);"string"==typeof a&&(a=[[e.i,a,""]]);var n={hmr:!0,transform:void 0,insertInto:void 0};r(6)(a,n);a.locals&&(e.exports=a.locals)},5:function(e,t,r){"use strict";e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var r=function(e,t){var r=e[1]||"",a=e[3];if(!a)return r;if(t&&"function"==typeof btoa){var n=(o=a,i=btoa(unescape(encodeURIComponent(JSON.stringify(o)))),l="sourceMappingURL=data:application/json;charset=utf-8;base64,".concat(i),"/*# ".concat(l," */")),s=a.sources.map((function(e){return"/*# sourceURL=".concat(a.sourceRoot||"").concat(e," */")}));return[r].concat(s).concat([n]).join("\n")}var o,i,l;return[r].join("\n")}(t,e);return t[2]?"@media ".concat(t[2]," {").concat(r,"}"):r})).join("")},t.i=function(e,r,a){"string"==typeof e&&(e=[[null,e,""]]);var n={};if(a)for(var s=0;s<this.length;s++){var o=this[s][0];null!=o&&(n[o]=!0)}for(var i=0;i<e.length;i++){var l=[].concat(e[i]);a&&n[l[0]]||(r&&(l[2]?l[2]="".concat(r," and ").concat(l[2]):l[2]=r),t.push(l))}},t}},6:function(e,t,r){var a,n,s={},o=(a=function(){return window&&document&&document.all&&!window.atob},function(){return void 0===n&&(n=a.apply(this,arguments)),n}),i=function(e,t){return t?t.querySelector(e):document.querySelector(e)},l=function(e){var t={};return function(e,r){if("function"==typeof e)return e();if(void 0===t[e]){var a=i.call(this,e,r);if(window.HTMLIFrameElement&&a instanceof window.HTMLIFrameElement)try{a=a.contentDocument.head}catch(e){a=null}t[e]=a}return t[e]}}(),c=null,u=0,d=[],p=r(13);function f(e,t){for(var r=0;r<e.length;r++){var a=e[r],n=s[a.id];if(n){n.refs++;for(var o=0;o<n.parts.length;o++)n.parts[o](a.parts[o]);for(;o<a.parts.length;o++)n.parts.push(b(a.parts[o],t))}else{var i=[];for(o=0;o<a.parts.length;o++)i.push(b(a.parts[o],t));s[a.id]={id:a.id,refs:1,parts:i}}}}function v(e,t){for(var r=[],a={},n=0;n<e.length;n++){var s=e[n],o=t.base?s[0]+t.base:s[0],i={css:s[1],media:s[2],sourceMap:s[3]};a[o]?a[o].parts.push(i):r.push(a[o]={id:o,parts:[i]})}return r}function m(e,t){var r=l(e.insertInto);if(!r)throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var a=d[d.length-1];if("top"===e.insertAt)a?a.nextSibling?r.insertBefore(t,a.nextSibling):r.appendChild(t):r.insertBefore(t,r.firstChild),d.push(t);else if("bottom"===e.insertAt)r.appendChild(t);else{if("object"!=typeof e.insertAt||!e.insertAt.before)throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");var n=l(e.insertAt.before,r);r.insertBefore(t,n)}}function g(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e);var t=d.indexOf(e);t>=0&&d.splice(t,1)}function h(e){var t=document.createElement("style");if(void 0===e.attrs.type&&(e.attrs.type="text/css"),void 0===e.attrs.nonce){var a=function(){0;return r.nc}();a&&(e.attrs.nonce=a)}return w(t,e.attrs),m(e,t),t}function w(e,t){Object.keys(t).forEach((function(r){e.setAttribute(r,t[r])}))}function b(e,t){var r,a,n,s;if(t.transform&&e.css){if(!(s="function"==typeof t.transform?t.transform(e.css):t.transform.default(e.css)))return function(){};e.css=s}if(t.singleton){var o=u++;r=c||(c=h(t)),a=x.bind(null,r,o,!1),n=x.bind(null,r,o,!0)}else e.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(r=function(e){var t=document.createElement("link");return void 0===e.attrs.type&&(e.attrs.type="text/css"),e.attrs.rel="stylesheet",w(t,e.attrs),m(e,t),t}(t),a=j.bind(null,r,t),n=function(){g(r),r.href&&URL.revokeObjectURL(r.href)}):(r=h(t),a=C.bind(null,r),n=function(){g(r)});return a(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;a(e=t)}else n()}}e.exports=function(e,t){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw new Error("The style-loader cannot be used in a non-browser environment");(t=t||{}).attrs="object"==typeof t.attrs?t.attrs:{},t.singleton||"boolean"==typeof t.singleton||(t.singleton=o()),t.insertInto||(t.insertInto="head"),t.insertAt||(t.insertAt="bottom");var r=v(e,t);return f(r,t),function(e){for(var a=[],n=0;n<r.length;n++){var o=r[n];(i=s[o.id]).refs--,a.push(i)}e&&f(v(e,t),t);for(n=0;n<a.length;n++){var i;if(0===(i=a[n]).refs){for(var l=0;l<i.parts.length;l++)i.parts[l]();delete s[i.id]}}}};var _,y=(_=[],function(e,t){return _[e]=t,_.filter(Boolean).join("\n")});function x(e,t,r,a){var n=r?"":a.css;if(e.styleSheet)e.styleSheet.cssText=y(t,n);else{var s=document.createTextNode(n),o=e.childNodes;o[t]&&e.removeChild(o[t]),o.length?e.insertBefore(s,o[t]):e.appendChild(s)}}function C(e,t){var r=t.css,a=t.media;if(a&&e.setAttribute("media",a),e.styleSheet)e.styleSheet.cssText=r;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(r))}}function j(e,t,r){var a=r.css,n=r.sourceMap,s=void 0===t.convertToAbsoluteUrls&&n;(t.convertToAbsoluteUrls||s)&&(a=p(a)),n&&(a+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(n))))+" */");var o=new Blob([a],{type:"text/css"}),i=e.href;e.href=URL.createObjectURL(o),i&&URL.revokeObjectURL(i)}},83:function(e,t,r){e.exports=r(84)},84:function(e,t,r){Vue.component("wt-profile",r(90).default)},85:function(e,t,r){"use strict";var a=r(27);r.n(a).a},86:function(e,t,r){(t=r(5)(!1)).push([e.i,"\n.user-pattern {\n    background-color: #ffffff;\n    background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 56 28' width='56' height='28'%3E%3Cpath fill='%23eaca64' fill-opacity='0.33' d='M56 26v2h-7.75c2.3-1.27 4.94-2 7.75-2zm-26 2a2 2 0 1 0-4 0h-4.09A25.98 25.98 0 0 0 0 16v-2c.67 0 1.34.02 2 .07V14a2 2 0 0 0-2-2v-2a4 4 0 0 1 3.98 3.6 28.09 28.09 0 0 1 2.8-3.86A8 8 0 0 0 0 6V4a9.99 9.99 0 0 1 8.17 4.23c.94-.95 1.96-1.83 3.03-2.63A13.98 13.98 0 0 0 0 0h7.75c2 1.1 3.73 2.63 5.1 4.45 1.12-.72 2.3-1.37 3.53-1.93A20.1 20.1 0 0 0 14.28 0h2.7c.45.56.88 1.14 1.29 1.74 1.3-.48 2.63-.87 4-1.15-.11-.2-.23-.4-.36-.59H26v.07a28.4 28.4 0 0 1 4 0V0h4.09l-.37.59c1.38.28 2.72.67 4.01 1.15.4-.6.84-1.18 1.3-1.74h2.69a20.1 20.1 0 0 0-2.1 2.52c1.23.56 2.41 1.2 3.54 1.93A16.08 16.08 0 0 1 48.25 0H56c-4.58 0-8.65 2.2-11.2 5.6 1.07.8 2.09 1.68 3.03 2.63A9.99 9.99 0 0 1 56 4v2a8 8 0 0 0-6.77 3.74c1.03 1.2 1.97 2.5 2.79 3.86A4 4 0 0 1 56 10v2a2 2 0 0 0-2 2.07 28.4 28.4 0 0 1 2-.07v2c-9.2 0-17.3 4.78-21.91 12H30zM7.75 28H0v-2c2.81 0 5.46.73 7.75 2zM56 20v2c-5.6 0-10.65 2.3-14.28 6h-2.7c4.04-4.89 10.15-8 16.98-8zm-39.03 8h-2.69C10.65 24.3 5.6 22 0 22v-2c6.83 0 12.94 3.11 16.97 8zm15.01-.4a28.09 28.09 0 0 1 2.8-3.86 8 8 0 0 0-13.55 0c1.03 1.2 1.97 2.5 2.79 3.86a4 4 0 0 1 7.96 0zm14.29-11.86c1.3-.48 2.63-.87 4-1.15a25.99 25.99 0 0 0-44.55 0c1.38.28 2.72.67 4.01 1.15a21.98 21.98 0 0 1 36.54 0zm-5.43 2.71c1.13-.72 2.3-1.37 3.54-1.93a19.98 19.98 0 0 0-32.76 0c1.23.56 2.41 1.2 3.54 1.93a15.98 15.98 0 0 1 25.68 0zm-4.67 3.78c.94-.95 1.96-1.83 3.03-2.63a13.98 13.98 0 0 0-22.4 0c1.07.8 2.09 1.68 3.03 2.63a9.99 9.99 0 0 1 16.34 0z'%3E%3C/path%3E%3C/svg%3E\");\n}\n",""]),e.exports=t},87:function(e,t,r){"use strict";var a=r(28);r.n(a).a},88:function(e,t,r){(t=r(5)(!1)).push([e.i,"\n.max-h-24 {\n    max-height: 8rem;\n}\n.max-w-24 {\n    max-width: 8rem;\n}\n",""]),e.exports=t},90:function(e,t,r){"use strict";r.r(t);var a={props:{user:{type:Object}}},n=(r(85),r(0)),s=Object(n.a)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"w-full user-pattern rounded-lg shadow"},[r("div",{staticClass:"flex flex-col sm:flex-row sm:justify-start items-center p-6"},[r("div",{staticClass:"px-4"},[r("img",{staticClass:"rounded-full border-2 shadow h-24 w-24",attrs:{src:e.user.avatar}})]),e._v(" "),r("div",{staticClass:"text-center sm:text-justify"},[r("div",{staticClass:"text-3xl text-gray-700"},[e._v(e._s(e.user.name))]),e._v(" "),r("div",{staticClass:"text-lg text-gray-800"},[e._v("Joined "+e._s(e.user.created_ago)+" • "+e._s(e.user.role))])])]),e._v(" "),r("div",{staticClass:"bg-white p-6"},[r("div",{staticClass:"px-6 py-2 text-xl uppercase 1border-b text-gray-700"},[e._v("About Me")]),e._v(" "),r("div",{staticClass:"px-6 py-3 font-reading"},[e._v("\n            "+e._s(e.user.about_me)+"\n        ")])])])}),[],!1,null,null,null).exports,o=r(10),i={name:"tensor-image-input",props:{imageUrl:{type:String,default:null},imageClass:{type:String,default:"w-full"}},data:function(){return{image:this.imageUrl}},methods:{openUploadDialog:function(){this.$refs.tensorImageFileInput.click()},processFileUpload:function(e){var t=e.target.files||e.dataTransfer.files;t.length&&this.createImage(t[0])},createImage:function(e){var t=new FileReader,r=this;t.onload=function(e){r.image=e.target.result,r.$emit("uploaded",e.target.result)},t.readAsDataURL(e)},removeImage:function(e){this.imageUrl=""}}},l=Object(n.a)(i,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[e.image?r("img",{class:e.imageClass,attrs:{src:e.image},on:{click:e.openUploadDialog}}):r("svg",{staticClass:"block stroke-current text-gray-500 cursor-pointer",class:e.imageClass,attrs:{xmlns:"http://www.w3.org/2000/svg",width:"100",height:"100",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"1","stroke-linecap":"round","stroke-linejoin":"round"},on:{click:e.openUploadDialog}},[r("rect",{attrs:{x:"3",y:"3",width:"18",height:"18",rx:"2",ry:"2"}}),r("circle",{attrs:{cx:"8.5",cy:"8.5",r:"1.5"}}),r("polyline",{attrs:{points:"21 15 16 10 5 21"}})]),e._v(" "),r("input",{ref:"tensorImageFileInput",staticStyle:{display:"none"},attrs:{type:"file"},on:{change:e.processFileUpload}})])}),[],!1,null,null,null).exports,c={name:"tensor-form-error",props:{errorBag:{type:Object,default:null},containerClass:{type:String,default:"bg-yellow-100 border border-orange-300"},messageClass:{type:String,default:"p-2 text-red-600"},errorClass:{type:String,default:"px-2 pb-2"}}},u=Object(n.a)(c,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return e.errorBag?r("div",{class:e.containerClass},[e.errorBag.message?r("div",{class:e.messageClass},[e._v("\n        "+e._s(e.errorBag.message)+"\n    ")]):e._e(),e._v(" "),e._l(Object.keys(e.errorBag.errors),(function(t){return r("div",e._l(e.errorBag.errors[t],(function(t){return r("div",{class:e.errorClass},[e._v("\n            "+e._s(t)+"\n        ")])})),0)}))],2):e._e()}),[],!1,null,null,null).exports,d={name:"user-profile-editor",props:{user:{type:Object},labelClass:{type:String,default:"mt-4 mb-2 uppercase text-gray-700"},inputClass:{type:String,default:"w-full p-3 border rounded outline:none"},btnClass:{type:String,default:"px-6 py-3 bg-green-500 text-lg text-white hover:bg-green-700 rounded"},editLinkClass:{type:String,default:"cursor-pointer py-4 text-blue-600 hover:text-blue-700"}},components:{TensorImageInput:l,TensorFormError:u},data:function(){return{avatarBase64Data:null,aboutMe:this.user.about_me,name:this.user.name,current_password:"",new_password:"",new_password_confirmation:"",tab:"info",message:"",errors:null}},methods:{imageUploaded:function(e){this.avatarBase64Data=e},save:function(){var e=this,t={name:this.name,about_me:this.aboutMe};this.avatarBase64Data&&(t.avatar_base64=this.avatarBase64Data),o.b("/api/profile",t,(function(t){e.$emit("saved",t)}),(function(t){return e.errors=t}))},cancel:function(){this.$emit("cancelled")},resetPassword:function(){var e=this,t={current_password:this.current_password,new_password:this.new_password,new_password_confirmation:this.new_password_confirmation},r=this;o.b("/api/users/password",t,(function(e){r.message="Password Changed Successfully"}),(function(t){return e.errors=t}))}}},p=(r(87),Object(n.a)(d,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",["info"===e.tab?r("div",{staticClass:"w-full my-2 bg-gray-100 px-12 py-3 rounded-lg"},[r("div",{staticClass:"my-2"},[r("div",{class:e.labelClass},[e._v("Profile Image")]),e._v(" "),r("div",{staticClass:"mb-2"},[r("TensorImageInput",{attrs:{"image-url":e.user.avatar,"image-class":"max-w-24 max-h-24 cursor-pointer border-2 object-cover"},on:{uploaded:e.imageUploaded}})],1)]),e._v(" "),r("div",{staticClass:"my-2"},[r("div",{class:e.labelClass},[e._v("Name")]),e._v(" "),r("div",{staticClass:"mb-2"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.name,expression:"name"}],class:e.inputClass,attrs:{type:"text"},domProps:{value:e.name},on:{input:function(t){t.target.composing||(e.name=t.target.value)}}})])]),e._v(" "),r("div",{staticClass:"my-2"},[r("div",{class:e.labelClass},[e._v("About Me")]),e._v(" "),r("div",{staticClass:"mb-2"},[r("textarea",{directives:[{name:"model",rawName:"v-model",value:e.aboutMe,expression:"aboutMe"}],class:e.inputClass,domProps:{value:e.aboutMe},on:{input:function(t){t.target.composing||(e.aboutMe=t.target.value)}}})])]),e._v(" "),r("div",{staticClass:"my-2"},[r("div",{class:e.labelClass},[e._v("Security")]),e._v(" "),r("div",{staticClass:"mb-2"},[r("span",{staticClass:"text-blue-600 cursor-pointer inline-block",on:{click:function(t){e.tab="password"}}},[e._v("Change Current Password")])])]),e._v(" "),e.errors?r("TensorFormError",{attrs:{"error-bag":e.errors,"container-class":"px-6 py-2 mt-6 -mb-8 bg-yellow-100 border border-orange-300"}}):e._e(),e._v(" "),r("div",{staticClass:"mt-8 border-t py-4"},[r("button",{class:e.btnClass,attrs:{type:"button"},on:{click:e.save}},[e._v("Save")]),e._v(" "),r("span",{staticClass:"ml-4 text-blue-600 cursor-pointer inline-block",on:{click:e.cancel}},[e._v("Cancel")])])],1):e._e(),e._v(" "),"password"===e.tab?r("div",{staticClass:"pt-4 w-full"},[e.errors?r("TensorFormError",{attrs:{"error-bag":e.errors,"container-class":"px-6 py-2 mb-6 bg-yellow-100 border border-orange-300"}}):e._e(),e._v(" "),r("div",{staticClass:"px-6 w-full mb-4"},[r("label",{staticClass:"block text-gray-700 text-sm mb-2 flex justify-between",attrs:{for:"currrent_password"}},[e._v("\n                    Current Password\n                ")]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.current_password,expression:"current_password"}],staticClass:"px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none",attrs:{"aria-label":"Password",id:"current_password",type:"password",required:"",autocomplete:"current-password",placeholder:"********"},domProps:{value:e.current_password},on:{input:function(t){t.target.composing||(e.current_password=t.target.value)}}})]),e._v(" "),r("div",{staticClass:"px-6 w-full mb-4"},[r("label",{staticClass:"block text-gray-700 text-sm mb-2 flex justify-between",attrs:{for:"new_password"}},[e._v("\n                    New Password\n                ")]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.new_password,expression:"new_password"}],staticClass:"px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none",attrs:{"aria-label":"Password",id:"new_password",type:"password",required:"",placeholder:"********"},domProps:{value:e.new_password},on:{input:function(t){t.target.composing||(e.new_password=t.target.value)}}}),e._v(" "),r("label",{staticClass:"block text-gray-700 text-sm my-2 flex justify-between",attrs:{for:"new_password_confirrmation"}},[e._v("\n                    Re-type New Password\n                ")]),e._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:e.new_password_confirmation,expression:"new_password_confirmation"}],staticClass:"px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none",attrs:{"aria-label":"Password",id:"new_password_confirmation",type:"password",required:"",placeholder:"********"},domProps:{value:e.new_password_confirmation},on:{input:function(t){t.target.composing||(e.new_password_confirmation=t.target.value)}}})]),e._v(" "),r("div",{staticClass:"px-6 w-full mt-8"},[r("span",{staticClass:"px-6 py-2 text-white bg-green-600 rounded cursor-pointer",on:{click:e.resetPassword}},[e._v("Change Password")]),e._v(" "),r("span",{staticClass:"ml-4 text-blue-600 cursor-pointer inline-block",on:{click:function(t){e.tab="info"}}},[e._v("Back")])]),e._v(" "),r("div",{staticClass:"px-6 w-full mt-4"},[e._v("\n            "+e._s(e.message)+"\n        ")])],1):e._e()])}),[],!1,null,null,null).exports),f={props:{page:{type:Object}},methods:{navigateTo:function(e){window.location.href=e}}},v=Object(n.a)(f,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"w-full p-3"},[r("div",{staticClass:"text-2xl text-blue-600 py-3 cursor-pointer hover:text-blue-800 font-heading",on:{click:function(t){return e.navigateTo(e.page.url)}}},[e._v("\n        "+e._s(e.page.title)+"\n    ")]),e._v(" "),r("div",{staticClass:"w-full"},[null!=e.page.media?r("img",{staticClass:"w-full object-cover",staticStyle:{"max-height":"12rem"},attrs:{src:e.page.media.url}}):r("img",{staticClass:"w-full object-cover",staticStyle:{"max-height":"12rem"},attrs:{src:"https://source.unsplash.com/random/400x300"}})]),e._v(" "),r("div",{staticClass:"w-full py-3"},[r("div",{staticClass:"text-gray-600 font-reading"},[e._v(e._s(e.page.summary))])]),e._v(" "),r("div",{staticClass:"py-3 text-blue-600 cursor-pointer hover:text-blue-800",on:{click:function(t){return e.navigateTo(e.page.url)}}},[e._v("\n        Read More...\n    ")])])}),[],!1,null,null,null).exports,m=r(11),g={name:"pages-by-user",props:{user:{type:Object},showDraft:{type:Boolean,default:!1}},data:function(){return{userPagesData:{}}},components:{Paginator:m.a,PageTile:v},created:function(){this.loadUserPages()},methods:{loadUserPages:function(e){var t=this;e=void 0===e?"/api/profiles/"+this.user.public_id+"/pages":e,o.a(e,(function(e){return t.userPagesData=e}))}}},h=Object(n.a)(g,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return e.userPagesData.hasOwnProperty("data")&&e.userPagesData.data.length>0?r("div",{staticClass:"my-4"},[r("div",{staticClass:"px-12 pt-3 text-xl uppercase text-gray-700"},[e._v("\n        Pages Created by "+e._s(e.user.name)+"\n    ")]),e._v(" "),r("div",{staticClass:"rounded-lg -mt-4"},[r("Paginator",{attrs:{"page-data":e.userPagesData,"container-class":"w-full px-6 md:flex md:flex-wrap md:items-start md:justify-between","nav-class":"w-full mt-4 p-4 flex justify-between items-center bg-gray-100"},on:{next:e.loadUserPages,previous:e.loadUserPages},scopedSlots:e._u([{key:"default",fn:function(e){return[r("PageTile",{attrs:{page:e.item}})]}}],null,!1,3508969356)})],1)]):e._e()}),[],!1,null,null,null).exports,w={props:{profile:{type:Object},showEditor:{type:Boolean,default:!1},showPages:{type:Boolean,default:!0},showComments:{type:Boolean,default:!1}},data:function(){return{user:this.profile,mode:"read"}},components:{UserTile:s,PagesByUser:h,UserProfileEditor:p},methods:{onSave:function(e){e.avatar+="?cachebuster="+Math.floor(Math.random()*Math.floor(100)),this.user=e,this.$root.authuser=e,this.mode="read"}}},b=Object(n.a)(w,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",["read"===e.mode?r("UserTile",{attrs:{user:e.user}}):e._e(),e._v(" "),e.showEditor&&"edit"===e.mode?r("div",[r("UserProfileEditor",{attrs:{user:e.user},on:{saved:e.onSave,cancelled:function(t){e.mode="read"}}})],1):e._e(),e._v(" "),e.showEditor&&"read"===e.mode?r("div",{staticClass:"text-right p-3"},[r("span",{staticClass:"text-blue-600 cursor-pointer",on:{click:function(t){e.mode="edit"}}},[e._v("Update Profile Data")])]):e._e(),e._v(" "),e.showPages&&"read"===e.mode?r("PagesByUser",{attrs:{user:e.user}}):e._e()],1)}),[],!1,null,null,null);t.default=b.exports}});