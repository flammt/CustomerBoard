import NextContactPage from "./components/NextContactPage";

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App.vue'
import ManageUsers from "./components/ManageUsers";
import BrowseAccounts from "./components/BrowseAccounts";
import Account from "./components/Account";
import UserEdit from "./components/UserEdit";
import UserNew from "./components/UserNew";
import AccountContacts from "./components/AccountContacts";
import AccountAddresses from "./components/AccountAddresses";
import AccountCommunications from "./components/AccountCommunications";
import AccountNew from "./components/AccountNew";
import AccountNewSub from "./components/AccountNewSub";
import AuxiliaryData from "./components/AuxiliaryData";
import AddressType from "./components/AddressType";
import AddressTypeForm from "./components/AddressTypeForm";
import CommunicationType from "./components/CommunicationType";
import CommunicationTypeForm from "./components/CommunicationTypeForm";
import ChangePassword from "./components/ChangePassword";
import Sector from "./components/Sector";
import SectorForm from "./components/SectorForm";
import ConnectionType from "./components/ConnectionType";
import ConnectionTypeForm from "./components/ConnectionTypeForm";
import RemarkType from "./components/RemarkType";
import RemarkTypeForm from "./components/RemarkTypeForm";
import NextContacts from "./components/NextContacts";
import CreateCommunication from "./components/CreateCommunication";

Vue.use(VueRouter);

const routes = [
    { path: '/', name:'rootRedirect', redirect: '/nextContacts/1' },
    { path: '/nextContacts', name:'nextContactsRedirect', redirect: '/nextContacts/1' },
    { path: '/browseAccounts', component: BrowseAccounts,
        children: [
            {
                path: 'accountNew/',
                component: AccountNew,
            },
            {
                path: 'account/:id',
                name: 'account',
                component: Account,
                props: true,
                children: [
                    {path: '', redirect: 'contacts'},
                    {path: 'contacts', name: 'contacts', component: AccountContacts},
                    {path: 'addresses', name: 'addresses', component: AccountAddresses},
                    {path: 'communications', name: 'communications', component: AccountCommunications},
                    {
                        path: ':sub/new',
                        name: 'newSub',
                        component: AccountNewSub,
                        props: true,
                    },
                ]
            }
        ]
    },
    {
        path: '/manageUsers', component: ManageUsers,
        children: [
            {path: 'user/new', component: UserNew},
            {path: 'user/:id', component: UserEdit, props: true}
        ]
    },
    {
        path: '/createCommunication', component:CreateCommunication,
    },
    {
        path: '/nextContacts', name: 'nextContacts', component:NextContacts,
        children: [
            {path: ':page', name:'nextContact', component: NextContactPage, props: true},
        ]
    },
    {
        path: '/auxData', component: AuxiliaryData,
        children: [
            {path: 'addressType', component: AddressType,
                children: [
                    {path: ':id', component: AddressTypeForm, props: true,},
                ]
            },
            {path: 'communicationType', component: CommunicationType,
                children: [
                    {path: ':id', component: CommunicationTypeForm, props: true,},
                ]
            },
            {path: 'sector', component: Sector,
                children: [
                    {path: ':id', component: SectorForm, props: true,},
                ]
            },
            {path: 'connectionType', component: ConnectionType,
                children: [
                    {path: ':id', component: ConnectionTypeForm, props: true,},
                ]
            },
            {path: 'remarkType', component: RemarkType,
                children: [
                    {path: ':id', component: RemarkTypeForm, props: true,},
                ]
            },
        ]
    },
    {
        path: '/changePassword', component:ChangePassword,
    },
];

const router = new VueRouter({
    routes, // short for `routes: routes`
});

new Vue({
    router,
    render: h => h(App),
}).$mount('#app');

Vue.directive('on-click-outside', {
    bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            // here I check that click was outside the el and his children
            if (!(el == event.target || el.contains(event.target))) {
                // and if it did, call method provided in attribute value
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});