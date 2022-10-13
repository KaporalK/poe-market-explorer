import React, { Component } from 'react';
import { makeApiCall } from '../utils/ApiHelper';
import { makeUrl } from '../utils/makeUrl';
import ItemList from './ItemList';
import FiltersList from './Filters/FiltersList';
import Button from '@mui/material/Button';
import { css } from 'glamor';
import { primaryColor } from '../style/defaultTheme';

const margin = {
  padding: '20px',
}

class SearchApp extends Component {

  constructor(props) {
    super(props)

    this.state = {
      result: [],
      listRef: React.createRef(),
      FilterListRef: React.createRef(),
      page: 1,
      filters: {},
    }
  }

  addFilter(filter) {
    this.setState(prevState => ({
      filters: { ...prevState.filters, ...filter }
    }))
  }

  addModFilter(mod) {
    this.state.FilterListRef.current.addModFilter(mod)
  }

  deleteFilter(filterName) {
    let modFiltersState = {}
    Object.assign(modFiltersState, this.state.filters)
    delete modFiltersState['mods' + filterName]
    this.setState({
      filters: { ...modFiltersState }
    })
  }

  clearFilter() {
    this.setState({
      filters: {},
    })
  }

  changeResult(newResult) {
    this.setState({
      result: newResult
    });
  }

  confirmSearch(filters) {
    this.state.listRef.current.setState({
      loading: true
    });

    //todo env
    const url = makeUrl('https://localhost/items', filters);
    console.log(url);
    this.setState({
      lastQuery: url
    });
    this.state.listRef.current.setState({
      items: []
    });
    this.updateItemList(url, 1);
  }

  nextPage() {
    if (this.state.lastQuery !== undefined) {
      this.updateItemList(this.state.lastQuery, this.state.page + 1);
    }
  }

  updateItemList(url, page) {
    const json = makeApiCall(url, page);
    json.then((e) => {
      this.state.listRef.current.setState({
        loading: false
      });
      this.state.listRef.current.addItems(e['hydra:member']);
      this.setState({
        page: page,
      })
    });
  }

  render() {
    return (
      <div {...css(margin, primaryColor)}>
        <FiltersList
          valueConfirm={this.confirmSearch.bind(this)}
          addFilter={this.addFilter.bind(this)}
          deleteFilter={this.deleteFilter.bind(this)}
          clearFilter={this.clearFilter.bind(this)}
          ref={this.state.FilterListRef}
        > </FiltersList>
        <Button sx={{ m: '5px' }} className="button" variant="outlined" onClick={() => this.confirmSearch(this.state.filters)} >Search</Button>
        <ItemList items={[] /*TODO find out why this.state.result does not update the ItemList */}
          ref={this.state.listRef}
          addModFilter={this.addModFilter.bind(this)}>
        </ItemList>
        <Button sx={{ m: '5px' }} className="button" variant="outlined" onClick={() => this.nextPage()} >next page</Button>
      </div>
    );
  }
}

export default SearchApp;
