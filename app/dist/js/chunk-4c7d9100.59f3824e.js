(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-4c7d9100"],{"023e":function(t,a,e){"use strict";e("96cf");var r=e("3b8d"),n=e("eadc"),s=e("fbc6"),i=e("9a7a"),c="/v1/user";a["a"]={getByFilter:function(){var t=Object(r["a"])(regeneratorRuntime.mark(function t(a){var e,r;return regeneratorRuntime.wrap(function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,n["a"].get(c);case 2:return e=t.sent,r={users:s["a"].run({module:"User",data:i["a"].arrayGet(e,"data.users",[])}),paginate:s["a"].run({module:"Paginate",data:i["a"].arrayGet(e,"data.paginate",{}),type:"object"})},t.abrupt("return",r);case 5:case"end":return t.stop()}},t)}));function a(a){return t.apply(this,arguments)}return a}(),getInfo:function(){var t=Object(r["a"])(regeneratorRuntime.mark(function t(a){var e,r;return regeneratorRuntime.wrap(function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,n["a"].get("".concat(c,"/info"));case 2:return e=t.sent,r=s["a"].run({module:"User",data:i["a"].arrayGet(e,"data",{}),type:"object"}),t.abrupt("return",r);case 5:case"end":return t.stop()}},t)}));function a(a){return t.apply(this,arguments)}return a}(),login:function(t){return n["a"].post("/v1/auth/login",{email:t.email,password:t.password})},add:function(t){return n["a"].post("/v1/user/create",{email:t.email,password:t.password,fullname:t.fullname})}}},b1b0:function(t,a,e){"use strict";e.r(a);var r=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"content-wrapper"},[t._m(0),e("section",{staticClass:"content"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-xs-12"},[e("div",{staticClass:"box"},[t._m(1),e("div",{staticClass:"box-body table-responsive"},[e("table",{staticClass:"table table-hover"},[t._m(2),e("tbody",{staticClass:"table-product-body"},t._l(t.data,function(a){return e("tr",[e("td"),e("td",[t._v(t._s(a.fullname))]),e("td",[t._v(t._s(a.email))]),e("td",[t._v(t._s(a.created_at))]),e("td")])}),0)])])])])])]),e("userAdd")],1)},n=[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("section",{staticClass:"content-header"},[e("h1",[t._v("\n      Người dùng\n      "),e("small",[t._v("Danh sách")])]),e("ol",{staticClass:"breadcrumb"},[e("li",[e("a",{attrs:{href:"#"}},[e("i",{staticClass:"fa fa-dashboard"}),t._v(" Home")])]),e("li",[e("a",{attrs:{href:"#"}},[t._v("Tables")])]),e("li",{staticClass:"active"},[t._v("Simple")])])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"box-header clearfix"},[e("div",{staticClass:"input-group input-group-sm pull-left",staticStyle:{width:"150px"}},[e("input",{staticClass:"form-control pull-right",attrs:{type:"text",name:"table_search",placeholder:"Search"}}),e("div",{staticClass:"input-group-btn"},[e("button",{staticClass:"btn btn-default",attrs:{type:"submit"}},[e("i",{staticClass:"fa fa-search"})])])]),e("button",{staticClass:"btn btn-info btn-sm pull-right",attrs:{type:"button","data-toggle":"modal","data-target":"#user-add"}},[t._v("Thêm mới")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("thead",[e("tr",[e("th",[t._v("STT")]),e("th",[t._v("Họ và tên")]),e("th",[t._v("Email")]),e("th",[t._v("Ngày tạo")]),e("th",[t._v("Tác vụ")])])])}],s=e("023e"),i={data:function(){return{data:[]}},components:{userAdd:function(){return e.e("chunk-0fb033d1").then(e.bind(null,"eae7"))}},watch:{},created:function(){this.getData()},methods:{getData:function(){var t=this;s["a"].getByFilter([]).then(function(a){t.data=a.users})}}},c=i,u=e("2877"),l=Object(u["a"])(c,r,n,!1,null,"6d68cdac",null);a["default"]=l.exports}}]);
//# sourceMappingURL=chunk-4c7d9100.59f3824e.js.map