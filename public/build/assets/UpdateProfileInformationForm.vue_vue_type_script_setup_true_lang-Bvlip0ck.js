import{d as _,Q as g,T as y,g as r,b as a,a as s,u as e,e as m,w as u,j as h,q as x,h as c,s as V,f as k,o as d,k as b}from"./app-YpPUOKsp.js";import{a as f,b as p,_ as v}from"./TextInput.vue_vue_type_script_setup_true_lang-VaDJ2O_k.js";import{P as w}from"./PrimaryButton-J63nUjSB.js";const N=a("header",null,[a("h2",{class:"text-lg font-medium text-gray-900"},"Profile Information"),a("p",{class:"mt-1 text-sm text-gray-600"}," Update your account's profile information and email address. ")],-1),S={key:0},B={class:"text-sm mt-2 text-gray-800"},C={class:"mt-2 font-medium text-sm text-green-600"},E={class:"flex items-center gap-4"},P={key:0,class:"text-sm text-gray-600"},I=_({__name:"UpdateProfileInformationForm",props:{mustVerifyEmail:{},status:{}},setup(U){const l=g().props.auth.user,t=y({name:l.name,email:l.email});return(i,o)=>(d(),r("section",null,[N,a("form",{onSubmit:o[2]||(o[2]=k(n=>e(t).patch(i.route("profile.update")),["prevent"])),class:"mt-6 space-y-6"},[a("div",null,[s(v,{for:"name",value:"Name"}),s(f,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:e(t).name,"onUpdate:modelValue":o[0]||(o[0]=n=>e(t).name=n),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),s(p,{class:"mt-2",message:e(t).errors.name},null,8,["message"])]),a("div",null,[s(v,{for:"email",value:"Email"}),s(f,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(t).email,"onUpdate:modelValue":o[1]||(o[1]=n=>e(t).email=n),required:"",autocomplete:"username"},null,8,["modelValue"]),s(p,{class:"mt-2",message:e(t).errors.email},null,8,["message"])]),i.mustVerifyEmail&&e(l).email_verified_at===null?(d(),r("div",S,[a("p",B,[m(" Your email address is unverified. "),s(e(b),{href:i.route("verification.send"),method:"post",as:"button",class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:u(()=>[m(" Click here to re-send the verification email. ")]),_:1},8,["href"])]),h(a("div",C," A new verification link has been sent to your email address. ",512),[[x,i.status==="verification-link-sent"]])])):c("",!0),a("div",E,[s(w,{disabled:e(t).processing},{default:u(()=>[m("Save")]),_:1},8,["disabled"]),s(V,{"enter-active-class":"transition ease-in-out","enter-from-class":"opacity-0","leave-active-class":"transition ease-in-out","leave-to-class":"opacity-0"},{default:u(()=>[e(t).recentlySuccessful?(d(),r("p",P,"Saved.")):c("",!0)]),_:1})])],32)]))}});export{I as _};
