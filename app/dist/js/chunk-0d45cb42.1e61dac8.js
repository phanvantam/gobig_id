(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-0d45cb42"],{"023e":function(t,a,e){"use strict";e("96cf");var n=e("3b8d"),s=e("eadc"),r=e("fbc6"),o=e("9a7a"),i="/v1/user";a["a"]={getByFilter:function(){var t=Object(n["a"])(regeneratorRuntime.mark(function t(a){var e,n;return regeneratorRuntime.wrap(function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,s["a"].get(i);case 2:return e=t.sent,n={users:r["a"].run({module:"User",data:o["a"].arrayGet(e,"data.users",[])}),paginate:r["a"].run({module:"Paginate",data:o["a"].arrayGet(e,"data.paginate",{}),type:"object"})},t.abrupt("return",n);case 5:case"end":return t.stop()}},t)}));function a(a){return t.apply(this,arguments)}return a}(),getInfo:function(){var t=Object(n["a"])(regeneratorRuntime.mark(function t(a){var e,n;return regeneratorRuntime.wrap(function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,s["a"].get("".concat(i,"/info"));case 2:return e=t.sent,n=r["a"].run({module:"User",data:o["a"].arrayGet(e,"data",{}),type:"object"}),t.abrupt("return",n);case 5:case"end":return t.stop()}},t)}));function a(a){return t.apply(this,arguments)}return a}(),login:function(t){return s["a"].post("/v1/auth/login",{email:t.email,password:t.password})},add:function(t){return s["a"].post("/v1/user/create",{email:t.email,password:t.password,fullname:t.fullname})}}},5388:function(t,a,e){"use strict";e.r(a);var n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"login-box"},[t._m(0),e("div",{staticClass:"login-box-body"},[e("p",{staticClass:"login-box-msg"},[t._v("Sign in to start your session")]),e("div",[e("div",{staticClass:"form-group has-feedback"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.data.email,expression:"data.email"}],staticClass:"form-control",attrs:{type:"email",placeholder:"Email"},domProps:{value:t.data.email},on:{input:function(a){a.target.composing||t.$set(t.data,"email",a.target.value)}}}),e("span",{staticClass:"glyphicon glyphicon-envelope form-control-feedback"})]),e("div",{staticClass:"form-group has-feedback"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.data.password,expression:"data.password"}],staticClass:"form-control",attrs:{type:"password",placeholder:"Password"},domProps:{value:t.data.password},on:{input:function(a){a.target.composing||t.$set(t.data,"password",a.target.value)}}}),e("span",{staticClass:"glyphicon glyphicon-lock form-control-feedback"})]),e("div",{staticClass:"row"},[t._m(1),e("div",{staticClass:"col-xs-4"},[e("button",{staticClass:"btn btn-primary btn-block btn-flat",attrs:{type:"submit"},on:{click:t.submit}},[t._v("Đăng nhập")])])])])])])},s=[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"login-logo"},[e("a",{attrs:{href:"../../index2.html"}},[e("b",[t._v("Admin")]),t._v("LTE")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-xs-8"},[e("div",{staticClass:"checkbox icheck"},[e("label",[e("input",{attrs:{type:"checkbox"}}),t._v(" Remember Me\n            ")])])])}],r=e("023e"),o=e("9a7a"),i={data:function(){return{data:{email:null,password:null}}},components:{},watch:{},created:function(){},methods:{submit:function(){var t=this;r["a"].login(this.data).then(function(a){switch(a.status){case 1:o["a"].saveAccessToken(a.data.access_token,a.data.exp),t.$notify({text:"Đăng nhập thành công",type:"success"}),t.$router.push({name:"user"});break;case 0:null===a.messages?t.$notify({text:"Sai tài khoản hoặc mật khẩu",type:"error"}):a.messages.list.map(function(a){t.$notify({text:a,type:"error"})});break}})}}},c=i,l=e("2877"),u=Object(l["a"])(c,n,s,!1,null,null,null);a["default"]=u.exports}}]);
//# sourceMappingURL=chunk-0d45cb42.1e61dac8.js.map