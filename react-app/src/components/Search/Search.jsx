import './Search.css';
import React, { Component } from 'react';
import CategoryFilter from './CategoryFilter';
import NameFilter from './NameFilter';
import RarityFilter from './RarityFilter';

class Search extends Component {

  constructor(props) {
    super(props)

    this.state = {
      valueConfirm: props.valueConfirm,
      filters: [],
    }
  }

  addFilter(filter) {
    this.setState(prevState => ({
      filters: { ...prevState.filters, ...filter }
    }))
  }

  addNameFilter(name) {
    this.setState({
      nameFilter: name
    })
  }

  confirmSearch() {
    let finalFilters = {}
    if (Object.keys(this.state.filters).length > 0 ) {
      finalFilters = { ...this.state.filters };
    }
    if (this.state.nameFilter !== undefined) {
      finalFilters = { ...finalFilters, ...this.state.nameFilter };
    }
    this.state.valueConfirm(finalFilters)
  }

  render() {
    return (
      <div className="search">
        <NameFilter addFilter={this.addNameFilter.bind(this)} className="filter"></NameFilter>
        <CategoryFilter addFilter={this.addFilter.bind(this)} className="filter"></CategoryFilter>
        <RarityFilter addFilter={this.addFilter.bind(this)} className="filter"></RarityFilter>
        <input type="submit" onClick={() => this.confirmSearch()} value='search'></input>
      </div>
    );
  }
}

export default Search;

