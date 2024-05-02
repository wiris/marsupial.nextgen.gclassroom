import{A as D}from"./ApplicationLogo-HuAUFngK.js";import{d as p,l as M,m as N,i as v,p as B,g as m,b as e,r as c,j as $,q as C,a as n,w as o,s as j,o as d,n as u,c as w,u as b,k as _,t as y,h as E,e as l}from"./app-YpPUOKsp.js";const z={class:"relative"},S=p({__name:"Dropdown",props:{align:{default:"right"},width:{default:"48"},contentClasses:{default:"py-1 bg-white"}},setup(i){const s=i,t=h=>{r.value&&h.key==="Escape"&&(r.value=!1)};M(()=>document.addEventListener("keydown",t)),N(()=>document.removeEventListener("keydown",t));const a=v(()=>({48:"w-48"})[s.width.toString()]),g=v(()=>s.align==="left"?"ltr:origin-top-left rtl:origin-top-right start-0":s.align==="right"?"ltr:origin-top-right rtl:origin-top-left end-0":"origin-top"),r=B(!1);return(h,f)=>(d(),m("div",z,[e("div",{onClick:f[0]||(f[0]=k=>r.value=!r.value)},[c(h.$slots,"trigger")]),$(e("div",{class:"fixed inset-0 z-40",onClick:f[1]||(f[1]=k=>r.value=!1)},null,512),[[C,r.value]]),n(j,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"opacity-0 scale-95","enter-to-class":"opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"opacity-100 scale-100","leave-to-class":"opacity-0 scale-95"},{default:o(()=>[$(e("div",{class:u(["absolute z-50 mt-2 rounded-md shadow-lg",[a.value,g.value]]),style:{display:"none"},onClick:f[2]||(f[2]=k=>r.value=!1)},[e("div",{class:u(["rounded-md ring-1 ring-black ring-opacity-5",h.contentClasses])},[c(h.$slots,"content")],2)],2),[[C,r.value]])]),_:3})]))}}),L=p({__name:"DropdownLink",props:{href:{}},setup(i){return(s,t)=>(d(),w(b(_),{href:s.href,class:"block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"},{default:o(()=>[c(s.$slots,"default")]),_:3},8,["href"]))}}),V=p({__name:"NavLink",props:{href:{},active:{type:Boolean}},setup(i){const s=i,t=v(()=>s.active?"inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out":"inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out");return(a,g)=>(d(),w(b(_),{href:a.href,class:u(t.value)},{default:o(()=>[c(a.$slots,"default")]),_:3},8,["href","class"]))}}),x=p({__name:"ResponsiveNavLink",props:{href:{},active:{type:Boolean}},setup(i){const s=i,t=v(()=>s.active?"block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out":"block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out");return(a,g)=>(d(),w(b(_),{href:a.href,class:u(t.value)},{default:o(()=>[c(a.$slots,"default")]),_:3},8,["href","class"]))}}),A={class:"min-h-screen bg-gray-100"},O={class:"bg-white border-b border-gray-100"},P={class:"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"},T={class:"flex justify-between h-16"},q={class:"flex"},R={class:"shrink-0 flex items-center"},U={class:"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"},F={class:"hidden sm:flex sm:items-center sm:ms-6"},G={class:"ms-3 relative"},H={class:"inline-flex rounded-md"},I={type:"button",class:"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"},J=e("svg",{class:"ms-2 -me-0.5 h-4 w-4",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","clip-rule":"evenodd"})],-1),K={class:"-me-2 flex items-center sm:hidden"},Q={class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},W={class:"pt-2 pb-3 space-y-1"},X={class:"pt-4 pb-1 border-t border-gray-200"},Y={class:"px-4"},Z={class:"font-medium text-base text-gray-800"},ee={class:"font-medium text-sm text-gray-500"},te={class:"mt-3 space-y-1"},se={key:0,class:"bg-white shadow"},oe={class:"max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"},re=p({__name:"AuthenticatedLayout",setup(i){const s=B(!1);return(t,a)=>(d(),m("div",null,[e("div",A,[e("nav",O,[e("div",P,[e("div",T,[e("div",q,[e("div",R,[n(b(_),{href:t.route("dashboard")},{default:o(()=>[n(D,{class:"block h-9 w-auto fill-current text-gray-800"})]),_:1},8,["href"])]),e("div",U,[n(V,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:o(()=>[l(" Dashboard ")]),_:1},8,["href","active"])])]),e("div",F,[e("div",G,[n(S,{align:"right",width:"48"},{trigger:o(()=>[e("span",H,[e("button",I,[l(y(t.$page.props.auth.user.name)+" ",1),J])])]),content:o(()=>[n(L,{href:t.route("profile.edit")},{default:o(()=>[l(" Profile ")]),_:1},8,["href"]),n(L,{href:t.route("logout"),method:"post",as:"button"},{default:o(()=>[l(" Log Out ")]),_:1},8,["href"])]),_:1})])]),e("div",K,[e("button",{onClick:a[0]||(a[0]=g=>s.value=!s.value),class:"inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"},[(d(),m("svg",Q,[e("path",{class:u({hidden:s.value,"inline-flex":!s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M4 6h16M4 12h16M4 18h16"},null,2),e("path",{class:u({hidden:!s.value,"inline-flex":s.value}),"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"},null,2)]))])])])]),e("div",{class:u([{block:s.value,hidden:!s.value},"sm:hidden"])},[e("div",W,[n(x,{href:t.route("dashboard"),active:t.route().current("dashboard")},{default:o(()=>[l(" Dashboard ")]),_:1},8,["href","active"])]),e("div",X,[e("div",Y,[e("div",Z,y(t.$page.props.auth.user.name),1),e("div",ee,y(t.$page.props.auth.user.email),1)]),e("div",te,[n(x,{href:t.route("profile.edit")},{default:o(()=>[l(" Profile ")]),_:1},8,["href"]),n(x,{href:t.route("logout"),method:"post",as:"button"},{default:o(()=>[l(" Log Out ")]),_:1},8,["href"])])])],2)]),t.$slots.header?(d(),m("header",se,[e("div",oe,[c(t.$slots,"header")])])):E("",!0),e("main",null,[c(t.$slots,"default")])])]))}});export{re as _};
