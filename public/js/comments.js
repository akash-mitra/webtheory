!function(t){var e={};function n(r){if(e[r])return e[r].exports;var s=e[r]={i:r,l:!1,exports:{}};return t[r].call(s.exports,s,s.exports,n),s.l=!0,s.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var s in t)n.d(r,s,function(e){return t[e]}.bind(null,s));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=72)}({0:function(t,e,n){"use strict";function r(t,e,n,r,s,o,a,i){var c,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=n,l._compiled=!0),r&&(l.functional=!0),o&&(l._scopeId="data-v-"+o),a?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},l._ssrRegister=c):s&&(c=i?function(){s.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:s),c)if(l.functional){l._injectStyles=c;var u=l.render;l.render=function(t,e){return c.call(e),u(t,e)}}else{var f=l.beforeCreate;l.beforeCreate=f?[].concat(f,c):[c]}return{exports:t,options:l}}n.d(e,"a",(function(){return r}))},19:function(t,e,n){var r=n(75);"string"==typeof r&&(r=[[t.i,r,""]]);var s={hmr:!0,transform:void 0,insertInto:void 0};n(6)(r,s);r.locals&&(t.exports=r.locals)},31:function(t,e){t.exports=function(t){var e="undefined"!=typeof window&&window.location;if(!e)throw new Error("fixUrls requires window.location");if(!t||"string"!=typeof t)return t;var n=e.protocol+"//"+e.host,r=n+e.pathname.replace(/\/[^\/]*$/,"/");return t.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,(function(t,e){var s,o=e.trim().replace(/^"(.*)"$/,(function(t,e){return e})).replace(/^'(.*)'$/,(function(t,e){return e}));return/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(o)?t:(s=0===o.indexOf("//")?o:0===o.indexOf("/")?n+o:r+o.replace(/^\.\//,""),"url("+JSON.stringify(s)+")")}))}},5:function(t,e,n){"use strict";t.exports=function(t){var e=[];return e.toString=function(){return this.map((function(e){var n=function(t,e){var n=t[1]||"",r=t[3];if(!r)return n;if(e&&"function"==typeof btoa){var s=(a=r,i=btoa(unescape(encodeURIComponent(JSON.stringify(a)))),c="sourceMappingURL=data:application/json;charset=utf-8;base64,".concat(i),"/*# ".concat(c," */")),o=r.sources.map((function(t){return"/*# sourceURL=".concat(r.sourceRoot||"").concat(t," */")}));return[n].concat(o).concat([s]).join("\n")}var a,i,c;return[n].join("\n")}(e,t);return e[2]?"@media ".concat(e[2]," {").concat(n,"}"):n})).join("")},e.i=function(t,n,r){"string"==typeof t&&(t=[[null,t,""]]);var s={};if(r)for(var o=0;o<this.length;o++){var a=this[o][0];null!=a&&(s[a]=!0)}for(var i=0;i<t.length;i++){var c=[].concat(t[i]);r&&s[c[0]]||(n&&(c[2]?c[2]="".concat(n," and ").concat(c[2]):c[2]=n),e.push(c))}},e}},6:function(t,e,n){var r,s,o={},a=(r=function(){return window&&document&&document.all&&!window.atob},function(){return void 0===s&&(s=r.apply(this,arguments)),s}),i=function(t,e){return e?e.querySelector(t):document.querySelector(t)},c=function(t){var e={};return function(t,n){if("function"==typeof t)return t();if(void 0===e[t]){var r=i.call(this,t,n);if(window.HTMLIFrameElement&&r instanceof window.HTMLIFrameElement)try{r=r.contentDocument.head}catch(t){r=null}e[t]=r}return e[t]}}(),l=null,u=0,f=[],d=n(31);function p(t,e){for(var n=0;n<t.length;n++){var r=t[n],s=o[r.id];if(s){s.refs++;for(var a=0;a<s.parts.length;a++)s.parts[a](r.parts[a]);for(;a<r.parts.length;a++)s.parts.push(x(r.parts[a],e))}else{var i=[];for(a=0;a<r.parts.length;a++)i.push(x(r.parts[a],e));o[r.id]={id:r.id,refs:1,parts:i}}}}function v(t,e){for(var n=[],r={},s=0;s<t.length;s++){var o=t[s],a=e.base?o[0]+e.base:o[0],i={css:o[1],media:o[2],sourceMap:o[3]};r[a]?r[a].parts.push(i):n.push(r[a]={id:a,parts:[i]})}return n}function m(t,e){var n=c(t.insertInto);if(!n)throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var r=f[f.length-1];if("top"===t.insertAt)r?r.nextSibling?n.insertBefore(e,r.nextSibling):n.appendChild(e):n.insertBefore(e,n.firstChild),f.push(e);else if("bottom"===t.insertAt)n.appendChild(e);else{if("object"!=typeof t.insertAt||!t.insertAt.before)throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");var s=c(t.insertAt.before,n);n.insertBefore(e,s)}}function h(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t);var e=f.indexOf(t);e>=0&&f.splice(e,1)}function g(t){var e=document.createElement("style");if(void 0===t.attrs.type&&(t.attrs.type="text/css"),void 0===t.attrs.nonce){var r=function(){0;return n.nc}();r&&(t.attrs.nonce=r)}return y(e,t.attrs),m(t,e),e}function y(t,e){Object.keys(e).forEach((function(n){t.setAttribute(n,e[n])}))}function x(t,e){var n,r,s,o;if(e.transform&&t.css){if(!(o="function"==typeof e.transform?e.transform(t.css):e.transform.default(t.css)))return function(){};t.css=o}if(e.singleton){var a=u++;n=l||(l=g(e)),r=w.bind(null,n,a,!1),s=w.bind(null,n,a,!0)}else t.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(n=function(t){var e=document.createElement("link");return void 0===t.attrs.type&&(t.attrs.type="text/css"),t.attrs.rel="stylesheet",y(e,t.attrs),m(t,e),e}(e),r=j.bind(null,n,e),s=function(){h(n),n.href&&URL.revokeObjectURL(n.href)}):(n=g(e),r=C.bind(null,n),s=function(){h(n)});return r(t),function(e){if(e){if(e.css===t.css&&e.media===t.media&&e.sourceMap===t.sourceMap)return;r(t=e)}else s()}}t.exports=function(t,e){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw new Error("The style-loader cannot be used in a non-browser environment");(e=e||{}).attrs="object"==typeof e.attrs?e.attrs:{},e.singleton||"boolean"==typeof e.singleton||(e.singleton=a()),e.insertInto||(e.insertInto="head"),e.insertAt||(e.insertAt="bottom");var n=v(t,e);return p(n,e),function(t){for(var r=[],s=0;s<n.length;s++){var a=n[s];(i=o[a.id]).refs--,r.push(i)}t&&p(v(t,e),e);for(s=0;s<r.length;s++){var i;if(0===(i=r[s]).refs){for(var c=0;c<i.parts.length;c++)i.parts[c]();delete o[i.id]}}}};var _,b=(_=[],function(t,e){return _[t]=e,_.filter(Boolean).join("\n")});function w(t,e,n,r){var s=n?"":r.css;if(t.styleSheet)t.styleSheet.cssText=b(e,s);else{var o=document.createTextNode(s),a=t.childNodes;a[e]&&t.removeChild(a[e]),a.length?t.insertBefore(o,a[e]):t.appendChild(o)}}function C(t,e){var n=e.css,r=e.media;if(r&&t.setAttribute("media",r),t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}function j(t,e,n){var r=n.css,s=n.sourceMap,o=void 0===e.convertToAbsoluteUrls&&s;(e.convertToAbsoluteUrls||o)&&(r=d(r)),s&&(r+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(s))))+" */");var a=new Blob([r],{type:"text/css"}),i=t.href;t.href=URL.createObjectURL(a),i&&URL.revokeObjectURL(i)}},72:function(t,e,n){t.exports=n(73)},73:function(t,e,n){Vue.component("wt-comments",n(82).default)},74:function(t,e,n){"use strict";var r=n(19);n.n(r).a},75:function(t,e,n){(e=n(5)(!1)).push([t.i,"\n.comment-strip-style[data-v-7f6bcc30] {\n}\n\n",""]),t.exports=e},82:function(t,e,n){"use strict";n.r(e);var r={props:{content_type:{required:!0,type:String},refid:{required:!0,type:String}},data:function(){return{comments:{},comment:"",replyText:"",unsavedComment:{}}},created:function(){this.loadInitialComments()},methods:{loadInitialComments:function(){var t=this;this.ajaxGet(this.getUrl(),(function(e){t.comments=e}))},loadMoreComments:function(){var t=this;this.ajaxGet(this.getUrl(),(function(e){for(var n=e.data.length,r=0;r<n;r++)t.comments.data.push(e.data[r]);t.comments.next_page_url=e.next_page_url}))},postComment:function(){var t={body:this.comment,created_ago:"just now",replies:[],user:this.$root.$data.authuser},e=this;this.ajaxPost(this.postUrl(),t,(function(n){e.comments.data.unshift(t)}))},postReply:function(t){var e=this;this.ajaxPost(this.postUrl(),{body:this.replyText,parent_id:t.parent_id},(function(n){t.body=e.replyText,e.replyText=""}))},openReplyBox:function(t){this.comments.data.filter((function(e){return e.id===t}))[0].replies.unshift({body:"",parent_id:t,user:this.$root.$data.authuser})},ajaxGet:function(t,e){var n=new XMLHttpRequest;n.onreadystatechange=function(){this.readyState==XMLHttpRequest.DONE&&200==this.status&&e(JSON.parse(n.responseText))},n.open("GET",t,!0),n.send()},ajaxPost:function(t,e,n){var r=new XMLHttpRequest;r.onreadystatechange=function(){this.readyState==XMLHttpRequest.DONE&&200==this.status&&n(JSON.parse(r.responseText))},r.open("POST",t,!0),r.setRequestHeader("Content-Type","application/json;charset=UTF-8"),e._token=window.csrf_token,r.send(JSON.stringify(e))},getUrl:function(){var t,e="single"===this.content_type?"pages":"categories";return null!==(t=this.comments.next_page_url)&&void 0!==t?t:"/api/"+e+"/"+this.refid+"/comments"},postUrl:function(){return"/api/"+("single"===this.content_type?"pages":"categories")+"/"+this.refid+"/comments"},showLoginOption:function(){this.$root.$data.isLoginModalOpen=!0}}},s=(n(74),n(0)),o=Object(s.a)(r,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"w-full mb-3 py-4"},[n("h4",{staticClass:"text-xl"},[t._v(t._s(t.comments.total)+" Comments")])]),t._v(" "),n("div",[this.$root.$data.authuser?n("div",{staticClass:"w-full flex p-4 bg-gray-100 border rounded-lg mb-2"},[n("a",{attrs:{href:this.$root.$data.authuser.url}},[n("img",{staticClass:"h-12 w-12 rounded-full",attrs:{src:this.$root.$data.authuser.avatar}})]),t._v(" "),n("div",{staticClass:"w-full text-sm px-4"},[n("div",[n("span",{staticClass:"text-blue-800 font-bold"},[t._v(t._s(this.$root.$data.authuser.name))]),t._v(" "),n("span",{staticClass:"ml-3"},[t._v("— Join the discussion")])]),t._v(" "),n("div",{staticClass:"w-full text-gray-800"},[n("textarea",{directives:[{name:"model",rawName:"v-model",value:t.comment,expression:"comment"}],staticClass:"mt-2 border-2 rounded p-2 w-full h-12",attrs:{onclick:"this.classList.remove('h-12')"},domProps:{value:t.comment},on:{input:function(e){e.target.composing||(t.comment=e.target.value)}}}),t._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:t.comment.length>0,expression:"comment.length>0"}],staticClass:"w-full flex justify-end items-center mt-2"},[n("div",[n("span",{staticClass:"text-xs text-gray-200"},[t._v(t._s(t.comment.length)+" characters")])]),t._v(" "),n("button",{staticClass:"ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800",on:{click:t.postComment}},[t._v("Post")])])])])]):n("div",{staticClass:"w-full flex p-4 bg-gray-100 border rounded-lg mb-4 justify-between items-center"},[n("div",{staticClass:"text-xl"},[t._v("Join the Discussion.")]),t._v(" "),n("div",{staticClass:"bg-orange-600 text-white py-1 px-4 cursor-pointer rounded hover:bg-orange-800",on:{click:function(e){return e.stopPropagation(),t.showLoginOption(e)}}},[t._v("\n                Sign Up / Login\n            ")])]),t._v(" "),t._l(t.comments.data,(function(e){return n("div",{staticClass:"w-full flex p-4 border-b border-gray-200"},[n("a",{attrs:{href:e.user.url}},[n("img",{staticClass:"h-12 w-12 rounded-full",attrs:{src:e.user.avatar}})]),t._v(" "),n("div",{staticClass:"w-full text-sm px-4"},[n("div",{staticClass:"pb-1"},[n("span",{staticClass:"text-blue-800 font-bold tracking-wide"},[t._v(t._s(e.user.name))]),t._v(" "),n("span",{staticClass:"ml-1 text-gray-600"},[t._v("commented "+t._s(e.created_ago))])]),t._v(" "),n("div",{staticClass:"text-gray-800"},[t._v("\n                    "+t._s(e.body)+"\n                ")]),t._v(" "),n("div",{staticClass:"w-full flex justify-between py-1 text-gray-600 text-xs tracking-wide"},[n("div",{staticClass:"flex justify-start"},[n("button",{staticClass:"hover:text-orange-500",on:{click:function(n){return t.openReplyBox(e.id)}}},[t._v("Reply")]),t._v(" "),n("span",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"text-gray-600"},[t._v(" • ")]),t._v(" "),n("button",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"hover:text-orange-500"},[t._v("Like")])]),t._v(" "),e.replies.length>1?n("span",{staticClass:"hover:text-orange-500"},[t._v(t._s(e.replies.length)+" Replies")]):t._e()]),t._v(" "),t._l(e.replies,(function(e){return n("div",{staticClass:"w-full pt-6 flex"},[n("a",{attrs:{href:e.user.url}},[n("img",{staticClass:"h-12 w-12 rounded-full",attrs:{src:e.user.avatar}})]),t._v(" "),n("div",{staticClass:"w-full text-sm px-4"},[n("div",{staticClass:"pb-1"},[n("span",{staticClass:"text-blue-800 font-semibold tracking-wide"},[t._v(t._s(e.user.name))]),t._v(" "),n("span",{staticClass:"ml-1 text-gray-600"},[t._v("replied "+t._s(e.created_ago))])]),t._v(" "),e.body.length>0?n("div",{staticClass:"text-gray-800"},[t._v("\n                            "+t._s(e.body)+"\n\n                            "),n("div",{staticClass:"w-full flex justify-between py-1 text-gray-600 text-xs tracking-wide"},[n("div",{staticClass:"flex justify-start"},[n("button",{staticClass:"hover:text-orange-500",on:{click:function(n){return t.openReplyBox(e.parent_id)}}},[t._v("Reply")]),t._v(" "),n("span",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"text-gray-600"},[t._v(" • ")]),t._v(" "),n("button",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"hover:text-orange-500"},[t._v("Like")])])])]):n("div",{staticClass:"w-full text-gray-800 bg-gray-100"},[n("textarea",{directives:[{name:"model",rawName:"v-model",value:t.replyText,expression:"replyText"}],staticClass:"mt-2 border-2 rounded p-2 w-full h-12",attrs:{onclick:"this.classList.remove('h-12')"},domProps:{value:t.replyText},on:{input:function(e){e.target.composing||(t.replyText=e.target.value)}}}),t._v(" "),n("div",{directives:[{name:"show",rawName:"v-show",value:t.replyText.length>0,expression:"replyText.length>0"}],staticClass:"w-full flex justify-end items-center mt-2"},[n("div",[n("span",{staticClass:"text-xs text-gray-200"},[t._v(t._s(t.replyText.length)+" characters")])]),t._v(" "),n("button",{staticClass:"ml-3 bg-orange-600 text-white py-1 px-4 rounded hover:bg-orange-800",on:{click:function(n){return t.postReply(e)}}},[t._v("Post")])])])])])}))],2)])}))],2),t._v(" "),null!=t.comments.next_page_url?n("div",{staticClass:"mt-4"},[n("span",{staticClass:"px-3 py-1 cursor-pointer text-blue-700 text-sm",on:{click:t.loadMoreComments}},[t._v("Load more comments")])]):t._e()])}),[],!1,null,"7f6bcc30",null);e.default=o.exports}});