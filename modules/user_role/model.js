import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import Users from '../users/model.js'
import Role from '../ms_role/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(21),
		primaryKey: true
	},
	user_id: {
		type: DataTypes.CHAR(21),
	},
	role_id: {
		type: DataTypes.CHAR(21),
	}
}

const UserRole = sq.define('user_role',
	columns,
	{
		freezeTableName: true,
	    timestamps: true,
	    createdAt: 'created_at',
	    updatedAt: 'updated_at',
	    paranoid: true,
	    deletedAt: 'deleted_at',
	}
)

Users.hasMany(UserRole, { foreignKey: 'user_id'})
UserRole.belongsTo(Users, { foreignKey: 'user_id' })

Role.hasMany(UserRole, { foreignKey: 'role_id'})
UserRole.belongsTo(Role, { foreignKey: 'role_id' })

UserRole.allias = 'ur'

UserRole.$columns = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${UserRole.allias}.${str}`).join(',');
}

UserRole.$colAllias = (whitelist=[]) => {
	let arr = Object.keys(columns)
	/*===*/ arr.push('created_at'); arr.push('updated_at');
	if(whitelist.length) {
		arr = arr.filter(value => whitelist.includes(value))
	}
	return arr.map(str => `${UserRole.allias}.${str} AS ${UserRole.allias}__${str}`).join(',');
}

export default UserRole