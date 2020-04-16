
const AppState = {

    lastAccount: 0,

    get lastAccountId () {
        return this.lastAccount;
    },

    set lastAccountId (value) {
        this.lastAccount = value;
    },

    pathToAccount (id) {
        this.lastAccount = id
        return "/browseAccounts/account/" +id
    }
};

export default AppState;