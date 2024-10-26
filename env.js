import dotenv from 'dotenv';
dotenv.config()

export const env = (par, $default = null) => {
	if(process.env[par] === undefined)
		return $default
	else if(process.env[par] === '')
		return null
	else
		return process.env[par]
}

export const envBoolean = (par, $default = null) => {
	if(process.env[par] === undefined)
		return $default
	else if(process.env[par] === '')
		return null
	else {
	    if(process.env[par] === true)           return true
	    else if(process.env[par] === 't')       return true
	    else if(process.env[par] === 'true')    return true
	    else if(process.env[par] === 'TRUE')    return true
	    else if(process.env[par] === 'y')       return true
	    else if(process.env[par] === 'yes')     return true
	    else if(process.env[par] === 'on')      return true
	    else if(process.env[par] === 'ON')      return true
	    else if(process.env[par] === '1')       return true
	    else if(process.env[par] === 1)         return true

	    return false
	}
}