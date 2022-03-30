import React, { Component } from 'react';
import { makeApiCall } from '../utils/ApiHelper';
import { makeUrl } from '../utils/makeUrl';
import ItemList from './ItemList';
import Search from './Search/Search';

class PoeApp extends Component {

  constructor(props) {
    super(props)

    this.state = {
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

  confirmSearch(filters){
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

  nextPage(){
    if(this.state.lastQuery !== undefined){
      this.updateItemList(this.state.lastQuery, this.state.page + 1);
    }
  }

  updateItemList(url, page){
    const json = makeApiCall(url, page);
    json.then((e) => {
      this.state.listRef.current.setState({
        loading: false
      });
      this.state.listRef.current.addItems(e['hydra:member']);
      this.setState({
        page: page
      })
    });
  }

  render() {
    return (
        <div>
            <Search 
              valueConfirm={this.confirmSearch.bind(this)} 
            > </Search>
            <ItemList items={[]} ref={this.state.listRef}></ItemList>
            <input type='submit' value='next page' onClick={() => this.nextPage()}></input>
        </div>
    );
  }
}

export default PoeApp;
