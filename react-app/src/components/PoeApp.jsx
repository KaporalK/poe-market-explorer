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
    // this.state.listRef.current.updateItems([]);
    this.state.listRef.current.setState({
      loading: true
    });

    console.log(filters)
    const url = makeUrl('https://localhost/items', filters, this.state.page)
    console.log(url);
    //todo env
    const json = makeApiCall(url);
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
            <ItemList items={[]} ref={this.state.listRef}></ItemList>
        </div>
    );
  }
}

export default PoeApp;
