import React, { Component } from 'react';
import './App.css';
import PoeApp from './components/PoeApp';
import Header from './components/Header/Header';
import StackLoader from './components/Dialogs/AnimationLoader/StackLoader';

class App extends Component {
  render() {
    return (
      <div className="App">
        <Header />
        <p className="App-intro">
          I was changed on the Feature branch
        </p>
        <PoeApp />
      </div>
    );
  }
}

export default App;
