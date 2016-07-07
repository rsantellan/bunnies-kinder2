import React from 'react';
import ReactDOM from 'react-dom';
import $ from "jquery";

import UsersManagement from './parts/UsersManagement.jsx';
import UsersCounter from './parts/UsersCounter.jsx';


ReactDOM.render(
  <UsersCounter url="user-counter-url" />,
  document.getElementById("newsletterCounterContainer")
);

ReactDOM.render(
  <UsersManagement addUrlId="user-add-url" downloadUrlId="user-download-csv-url" searchUrlId="user-search-url" removeUrlId="user-remove-url" />,
  document.getElementById("newsletterUserManageContainer")
);


console.log('is loaded -1');