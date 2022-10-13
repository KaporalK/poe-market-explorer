import { css } from 'glamor';
import { createTheme, ThemeProvider } from '@mui/material/styles';
const darkTheme = createTheme({
    palette: {
      mode: 'dark',
    },
  });

const modHoverStyle = css({
    ":hover": {
        backgroundColor: '#808080',
    }
})

const placingStyle = css({
    borderRadius: '5px',
    margin: '5px',
    paddingLeft: '5px',
    paddingRight: '5px',
})

const childFilterMargin = css({
    '& > .filter': {
        margin: '2px',
    }
})

const childButtonMargin = css({
    '& > .button': {
        margin: '5px',
    }
})

const placingDivStyle = css({
    margin: '12px',
    paddingLeft: '10px',
    paddingRight: '10px',
})

const textTransformStyle = css({
    fontWeight: 'bolder',
    textTransform: 'uppercase',
    fontSize: '12px',
})

const flex = {
    display: 'flex',
}

const flexBoxCenter = {
    ...flex,
    justifyContent: 'center',
    alignContent: 'center',
    alignItems: 'center',
}

const flexEnd = {
    ...flex,
    justifyContent: 'flex-end',
}

const flexRow = css({
    flexDirection: 'row',
    justifyContent: 'space-evenly',
})

const flexColumn = css({
    flexDirection: 'column',
})

const filterWidth = css({
    '& > .filter': {
        width: '50%',
    }
})

const w100 = {
    width: '100%',
}

const h100 = {
    height: '100%',
}

const primaryColor = {
    backgroundColor: '#5b5b5b',
    color: '#c1c1c1'
}

const bgListStyle = {
    /*'&:nth-child(even)': {
        backgroundColor: '#B6AB95' //moche
    },*/
    '&:nth-child(odd)': {
        backgroundColor: '#7D7569'
    }
}

const bgOppacityStyle = {
    backgroundColor: '#808080',
}
/*
573E3E
7D7569
B6AB95
BBAF90
B19872
*/
export {
    modHoverStyle, placingStyle, placingDivStyle, filterWidth,
    textTransformStyle, flexBoxCenter, flexEnd, flexRow,
    flexColumn, childFilterMargin, childButtonMargin, w100, h100,
    bgListStyle, bgOppacityStyle, primaryColor, darkTheme as muiDarkTheme
}