(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{40:function(t,e,i){"use strict";i.r(e);var a={data:function(){return{templateId:null,fileName:null,isSaving:!1,sourceCode:"<html></html>",mode:null}},created:function(){this.mode=void 0===this.$route.params.fileIdentity?"create":"edit",this.templateId=this.$route.params.id,this.fetchContentAndLoadEditor()},components:{editor:i(21)},methods:{editorInit:function(){i(24),i(28)},fetchContentAndLoadEditor:function(){if(void 0!==this.$route.params.id&&parseInt(this.$route.params.id)>0&&void 0!==this.$route.params.fileIdentity){var t=this;util.ajax("get","/api/templates/"+this.$route.params.id+"/get/"+this.$route.params.fileIdentity,{},(function(e){t.fileName=atob(t.$route.params.fileIdentity),t.sourceCode=e}),(function(e,i){util.notifyError(i.status),t.$router.go(-1)}))}},isValid:function(){return!!this.fileName||(util.notifyError("Name missing","Template file must have a name."),!1)},initiateSave:function(){this.isValid()&&(this.isSaving=!0,util.ajax("post","/api/templates/"+this.$route.params.id+"/add",{name:this.fileName,code:this.sourceCode},this.postSaveProcessing))},postSaveProcessing:function(t){this.isSaving=!1,"create"===this.mode&&(this.mode="edit",this.$router.replace({path:"/app/templates/"+this.templateId+"/get/"+this.fileName})),util.toast({icon:"success",titleText:"File Saved Successfully"})}}},s=i(0),n=Object(s.a)(a,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"max-w-5xl mx-auto"},[i("div",{staticClass:"px-2 my-6 w-full flex justify-between items-baseline"},["edit"===t.mode?i("h2",{staticClass:"text-gray-600 text-2xl flex items-center"},[t._v(t._s(t.fileName))]):i("input",{directives:[{name:"model",rawName:"v-model",value:t.fileName,expression:"fileName"}],staticClass:"text-gray-600 text-2xl border border-gray-400 p-1 border-b-2 rounded bg-transparent",attrs:{type:"text",placeholder:"Enter file name"},domProps:{value:t.fileName},on:{input:function(e){e.target.composing||(t.fileName=e.target.value)}}}),t._v(" "),i("div",[i("t-button",{attrs:{color:"gray"},nativeOn:{click:function(e){return t.$router.go(-1)}}},[t._v("\n                Close\n            ")]),t._v("\n\n             \n\n            "),i("t-button",{attrs:{loadingWheel:t.isSaving},nativeOn:{click:function(e){return t.initiateSave(e)}}},[t._v("\n                Save\n            ")])],1)]),t._v(" "),i("div",{staticClass:"w-full rounded mb-12"},[i("editor",{attrs:{lang:"html",theme:"twilight",width:"100%",height:"500"},on:{init:t.editorInit},model:{value:t.sourceCode,callback:function(e){t.sourceCode=e},expression:"sourceCode"}})],1)])}),[],!1,null,null,null);e.default=n.exports}}]);