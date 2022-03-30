import React, { Component } from 'react';
import Autocomplete from '@mui/material/Autocomplete';
import TextField from '@mui/material/TextField';

//not accurate might need to update the back
class RarityFilter extends Component {

  constructor(props) {
    super(props)
    this.state = {
      addFilter: props.addFilter,
      className: props.className
    }
  }

  selectFilter(newValue) {
    this.state.addFilter({
      rarity: {
        str: `rarity=${newValue.id}`
      }
    });
  }

  render() {
    return (
      <div className={"rarityFilter " + this.state.className}>
        <Autocomplete
          id="rarity-filter"
          options={[
            { label: 'Any', id: -1 },
            { label: 'Normal', id: 0 },
            { label: 'Magic', id: 1 },
            { label: 'Rare', id: 2 },
            { label: 'Unique', id: 3 },
            { label: 'Unique(Relic)', id: 4 },
            { label: 'Any Non-unique', id: 7 },
          ]}
          onChange={(evet, newValue) => {
            this.selectFilter(newValue);
          }}
          renderInput={(params) => <TextField {...params} label="Item Rarity" />}
        />
      </div>
    );
  }
}

export default RarityFilter;
