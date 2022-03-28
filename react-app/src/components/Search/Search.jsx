import React, { Component } from 'react';
import CategoryFilter from './CategoryFilter';
import NameFilter from './NameFilter';

class Search extends Component {

  constructor(props) {
    super(props)

    this.state = {
      valueConfirm: props.valueConfirm,
      filters: [],
    }
  }

  addFilter(filter) {
    console.log(filter)
    this.setState(prevState => ({
      filters: [...prevState.filters, filter]
    }))
  }

  render() {
    return (
      <div className="Search">
        <CategoryFilter addFilter={this.addFilter.bind(this)}></CategoryFilter>
        <NameFilter change={console.log}></NameFilter>
        <input type="submit" onClick={() => this.state.valueConfirm(this.state.filters)} value='search'></input>
      </div>
    );
  }
}

export default Search;

