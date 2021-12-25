import React, { Component } from 'react';
import Searchbar from './Searchbar';
import CategoryFilter from './CategoryFilter';

class Search extends Component {

  constructor(props) {
    super(props)

    this.state = {
      valueConfirm: props.valueConfirm,
      searchValue: ''
    }
  }

  newValue(value){
    this.setState({
      searchValue: value
    })
  }

  render() {
    return (
      <div className="Search">
          <CategoryFilter></CategoryFilter>
          <Searchbar change={this.newValue.bind(this)}></Searchbar>
          <input type="submit" onClick={() => this.state.valueConfirm(this.state.searchValue)} value='search'></input>
      </div>
    );
  }
}

export default Search;
