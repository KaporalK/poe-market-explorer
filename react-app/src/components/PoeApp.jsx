import React, { Component } from 'react';
import { makeApiCall } from '../utils/ApiHelper';
import { makeUrl } from '../utils/makeUrl';
import ItemList from './ItemList';
import FiltersList from './Filters/FiltersList';
import Button from '@mui/material/Button';
import { css } from 'glamor';
import { muiDarkTheme, primaryColor, flexBoxCenter } from '../style/defaultTheme';
import { ThemeProvider } from '@mui/material/styles';
import Box from '@mui/material/Box';
import Tabs from '@mui/material/Tabs';
import Tab from '@mui/material/Tab';
import SearchApp from './SearchApp';

const margin = {
  padding: '20px',
}

class PoeApp extends Component {

  constructor(props) {
    super(props)

    this.state = {
      result: [],
      listRef: React.createRef(),
      FilterListRef: React.createRef(),
      menuValue: 0,
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
        <ThemeProvider theme={muiDarkTheme}>
          <Box sx={{...flexBoxCenter}}>
            <Tabs value={this.state.menuValue} onChange={(evnt, newValue) => this.setState({menuValue: newValue})} aria-label='Site menu'>
              <Tab value={0} label="Market" />
              <Tab value={1} label="Wanna buy" />
            </Tabs>
          </Box>
          <div hidden={this.state.menuValue !== 0}>
            <SearchApp></SearchApp>
          </div>
          <div hidden={this.state.menuValue !== 1}>
            Item Two
          </div>
        </ThemeProvider>
      </div>
    );
  }
}

export default PoeApp;
