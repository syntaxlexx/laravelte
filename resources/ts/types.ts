export type ResetSystemAction = {
    text: string,
    action: string,
}

export type SystemConfiguration = {
    id: number,
    name: string,
    type: 'bool' | 'text' | 'number',
    value?: string | boolean | number,
    created_at: Date,
    updated_at: Date,
    default?: string,
    description?: string,
    hint?: string,
}
