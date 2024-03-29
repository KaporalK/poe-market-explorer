import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import PoeApp from './components/PoeApp';

class App extends Component {
  render() {
    return (
      <div className="App">
        <header className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h1 className="App-title">Poe item finder todo</h1>
        </header>
        <PoeApp></PoeApp>
      </div>
    );
  }
}

export default App;
