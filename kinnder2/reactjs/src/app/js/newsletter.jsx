import React from 'react';
import ReactDOM from 'react-dom';

import NewsletterHandler from './NewsletterHandler.jsx';

/*
import UsersManagement from './parts/UsersManagement.jsx';
import GroupsManagement from './parts/GroupsManagement.jsx';
import UsersCounter from './parts/UsersCounter.jsx';
*/
/*
var userContentContainer = document.getElementById("newsletterCounterContainer");
if( userContentContainer !== null ){
	ReactDOM.render(
	  <UsersCounter url="user-counter-url" />,
	  userContentContainer
	);	
}


ReactDOM.render(
  <UsersManagement addUrlId="user-add-url" downloadUrlId="user-download-csv-url" searchUrlId="user-search-url" removeUrlId="user-remove-url" />,
  document.getElementById("newsletterUserManageContainer")
);

ReactDOM.render(
  <GroupsManagement addUrlId="user-group-add-url" searchUrlId="user-search-groups-url" editUrlId="user-group-edit-url" removeUrlId="user-group-remove-url" />,
  document.getElementById("newsletterGroupManageContainer")
);
*/

ReactDOM.render(
  <NewsletterHandler urlQuantity="user-counter-url" />,
  document.getElementById("newsletterContainer")
);

console.log('is loaded - 1');