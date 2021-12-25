import React, { Component } from 'react';
import ItemList from './ItemList';
import { makeApiCall } from '../utils/ApiHelper';
import Search from './Search/Search';

class PoeApp extends Component {

  constructor(props) {
    super(props)

    this.state = {
        searchValue: null,
        result: [],
        listRef: React.createRef(),
        page: 1,
    }
  }

  changeResult(newResult){
    this.setState({
      result: newResult
    });
  }

  confirmSearch(value){
    this.setState({
        searchValue: value,
        result: [...this.state.result, value]
    })
    // this.state.listRef.current.updateItems([]);
    this.state.listRef.current.setState({
      loading: true
    });

    //todo env
    const json = makeApiCall(`https://localhost/items?page=${this.state.page}`);
    json.then((e) => {
      this.state.listRef.current.setState({
        loading: false
      });
      this.state.listRef.current.addItems(e['hydra:member']);
      this.setState({
        page: this.state.page + 1
      })
    });
  }

  render() {
    return (
        <div>
            <Search valueConfirm={this.confirmSearch.bind(this)}></Search>
            <p>{this.state.searchValue}</p>
            <ItemList items={[]} ref={this.state.listRef}></ItemList>
        </div>
    );
  }
}

export default PoeApp;
