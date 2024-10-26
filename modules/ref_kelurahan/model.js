import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import Kecamatan from '../ref_kecamatan/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(10),
		primaryKey: true
	},
	kecamatan_id: {
		type: DataTypes.CHAR(6),
	},
	nama_kelurahan: {
		type: DataTypes.STRING
	},
	level_wilayah: {
		type: DataTypes.SMALLINT,
		defaultValue: 4
	}
}

let allias = 'kl'

const Kelurahan = sq.define('ref_kelurahan',
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

Kecamatan.hasMany(Kelurahan, { foreignKey: 'kecamatan_id' })
Kelurahan.belongsTo(Kecamatan, { foreignKey: 'kecamatan_id' })

export default Kelurahan