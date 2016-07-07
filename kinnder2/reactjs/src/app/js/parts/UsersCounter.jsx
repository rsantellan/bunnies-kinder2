import React from 'react';
import $ from "jquery";

class UsersCounter extends React.Component{

	constructor(props){
		super(props);
		this.state = {
			quantity: 0,
		}
		this.componentDidMount = this.componentDidMount.bind(this);
	}
	componentDidMount(){
		this.loadMetadata();
	}

	loadMetadata(){
		
		var that = this;
		$.ajax({
			url: $('#'+this.props.url).val(),
			type: 'post',
			dataType: "json",
            success: function (data) {
            	var sessionData = this.state;
            	sessionData['quantity'] = data.quantity;
            	this.setState(data);
            }.bind(this),
            error: function (xhr, status, err) {
                console.log($('#'+this.props.url).val(), status, err.toString());
            }.bind(this)
		});
		
	}

	render(){
		return (<div>
			<span>La cantidad de usuarios es: <strong>{ this.state.quantity }</strong></span>
			</div>);
	}
}

export default UsersCounter;