import React from 'react';

import $ from "jquery";

import UsersManagement from './parts/UsersManagement.jsx';
import GroupsManagement from './parts/GroupsManagement.jsx';
import UsersCounter from './parts/UsersCounter.jsx';

class NewsletterHandler extends React.Component{

	constructor(props){
		super(props);
		this.state = {
			step: 1,
			userQuantity: 0,

		}
		this.componentDidMount = this.componentDidMount.bind(this);
		this.loadUsersQuantity = this.loadUsersQuantity.bind(this);
	}

	componentDidMount(){
		this.loadUsersQuantity();
	}

	goToStateOne(){
		this.setState({step: 1});
	}

	goToStateZero(){
		this.setState({step: 0});
	}

	loadUsersQuantity(){
		
		var that = this;
		$.ajax({
			url: $('#'+this.props.urlQuantity).val(),
			type: 'post',
			dataType: "json",
            success: function (data) {
            	var sessionData = this.state;
            	sessionData['userQuantity'] = data.quantity;
            	this.setState(data);
            }.bind(this),
            error: function (xhr, status, err) {
                console.log($('#'+this.props.url).val(), status, err.toString());
            }.bind(this)
		});
		
	}

	render(){

		var quantitiesDiv = (
		<div className="row">
            <div className="col-lg-4">
                <UsersCounter quantity={this.state.userQuantity} />
            </div>
        </div>
        );
		switch(this.state.step){
			case 0:
			return (
				<div>
					{quantitiesDiv}

					<button className="btn btn-info" type="button" onClick={this.goToStateOne}>Manejar</button>
				</div>
				);
			break;
			case 1:
			return (
				<div>
					{quantitiesDiv}
					<button className="btn btn-info" type="button" onClick={this.goToStateZero}>Listar</button>
					<div className="row">
		                <div className="col-lg-6">
		                    <UsersManagement addUrlId="user-add-url" downloadUrlId="user-download-csv-url" searchUrlId="user-search-url" removeUrlId="user-remove-url" />
		                </div>
		                <div className="col-lg-6">
		                    <GroupsManagement addUrlId="user-group-add-url" searchUrlId="user-search-groups-url" editUrlId="user-group-edit-url" removeUrlId="user-group-remove-url" />
		                </div>
		            </div>
				</div>
				);
			break;
		}

		
	}
}

export default NewsletterHandler;