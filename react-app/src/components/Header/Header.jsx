import React, { Component } from 'react';
import logo from '../../assets/logo.svg';
import StackAnimation from '../Animations/StackAnimation';

class Header extends Component {
    constructor(props) {
        super(props);
        this.state = { isStopped: false, isPaused: false };
    }

    render() {
        return (
            <header className="App-header">
                <div className='Header-left'>
                    <h1 className="App-title">Poe item finder</h1>
                    <StackAnimation className="Header-logo-animation" isPaused={false} isStopped={false} autoplay={true} loop={true} />
                </div>
                <div className='Header-right'>
                    <img src={logo} className="App-logo" alt="logo" />
                </div>

            </header>
        );
    }
}

export default Header;
