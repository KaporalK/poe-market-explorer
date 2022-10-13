import React, { Component } from 'react';
import Item from './Item';
import Button from '@mui/material/Button';
import { flexBoxCenter, flexColumn, muiDarkTheme } from '../style/defaultTheme';
import { css } from 'glamor';


class ItemList extends Component {

  constructor(props) {
    super(props)
    this.state = {
      items: props.items,
      loading: false,
    }
  }

  updateItems(items) {
    this.setState({
      items: items
    })
  }

  addItems(items) {
    this.setState(prevState => ({
      items: [...prevState.items, ...items]
    }))
  }

  render() {
    return (
      <div {...css(flexBoxCenter, flexColumn)}>
        <Button {...muiDarkTheme} sx={{ m: '5px' }} variant="outlined" onClick={() => this.setState({ items: [], loading: false })} >clear list</Button>
        <div >
          {this.state.items.map((item, i) => {
            return <Item key={i} item={item}
              addModFilter={this.props.addModFilter}>
            </Item>
          })}
        </div>
        {this.state.loading ? <p>Loading</p> : ''}
      </div>
    );
  }
}

export default ItemList;
