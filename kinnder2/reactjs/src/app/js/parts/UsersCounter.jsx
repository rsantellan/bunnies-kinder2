import React from 'react';

class UsersCounter extends React.Component{

	constructor(props){
		super(props);
	}

	render(){
		return (<div>
			<span>La cantidad de usuarios es: <strong>{ this.props.quantity }</strong></span>
			</div>);
	}
}

export default UsersCounter;