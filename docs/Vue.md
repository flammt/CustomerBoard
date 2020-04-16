# Frontend Documentation
## Basics
All navigation is done with <router-link> and <router-view>.  
<router-view> is always another component that is being loaded depending on the activated
<router-link>.  
Exception is AccountNewSub which is one tab in Account but has multiple views.
These are realized with the route that was activated right before.
## Application Structure
1. **index.blade.php** / (*Forward to App.vue*)
1. **app.js** / (*Initialization and Routing*)
1. **App.vue** / (*Root Layout*)
    1. **NavBar.vue** / (*router-links for the content router-views*)
    1. **Header.vue**
    1. **Footer.vue**
    1. \<router-view>:
        1. **BrowseAccounts.vue** / (*all Account stuff*)
            1. Account Search Input
            1. Result list <router-links>
            1. "New" button
            1. \<router-view>
                1. **Account.vue** / (*the selected Account's details*)
                    1. **AccountNew.vue** / (*Form to create new Account*)
                    1. Tabbed Navigation
                    1. **AccountContacts.vue** / (*Display the Account's Contacts*)
                    1. **AccountAddresses.vue** / (*Display the Account's Addresses*)
                    1. **AccountCommunications.vue** / (*Display the Account's Communications*)
                    1. **AccountNewSub** / (*Forms for a new dataset depending on the previous
                     selected tab*)
                        1. New Contact
                        1. New Address
                        1. New Communication
                1. **AccountNew.vue** / (*Form for new Account*)
        1. **CreateCommunication.vue** / (*Parent for Communication.vue*)
            1. **Communication.vue** / (*Form for new Communication*)
        1. **ManageUsers.vue** / (*all User related*)
            1. User Search Input
            1. Result list <router-links>
            1. "New" button
            1. \<router-view>
                1. **UserNew.vue** (*Form for new User*)
                1. **UserEdit.vue** (*Display/edit the selected User*)
        1. **AuxiliaryData.vue** / (*all Misc stuff*)
        1. **ChangePassword.vue** / (*change password current user*)
## Data-Specific Components
- **AccountInputComboboxRow.vue** used to select an Account from the database
- **AccountLevelOptionRow.vue** used to select an Account Level
- **CommunicationTypeOptionRow.vue** used to select an Communication Type
- **ContactInputComboboxRow** used to select a Contact from the database
- **EditableAccountLevelOptionRow** editable Account Level display
- **EditableUserComboboxRow** editable User display
- **UserInputCombobox** User selector
- **UserInpotComboboxRow** User selector in a standardized form row
 
## Reusable Components (Selection)
- **ContextButtonRYS** Button which displays a context menu and requires approval
- **Form\*\*\*Row** Form Row components
- **Editable***** Editable Form Row components
- **MessageRow** used to display success- and error messages
- **PanelHeader** the latest 'Panel' component does not yet exist